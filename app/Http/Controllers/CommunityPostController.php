<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Community;
use App\Models\Post;
use App\Models\PostVote;
use App\Notifications\PostReportNotification;
use Illuminate\Support\Facades\Gate;
// use Image;
use Intervention\Image\Facades\Image;

class CommunityPostController extends Controller
{
    public function index(Community $community)
    {
        $posts = $community->posts()->latest('id')->paginate(4);
    }

    public function create(Community $community)
    {
        return view('posts.create', compact('community'));
    }

    public function store(StorePostRequest $request, Community $community)
    {
        $post =  $community->posts()->create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'post_text' => $request->post_text ?? null,
            'post_url' => $request->post_url ?? null,
        ]);
        if ($request->hasFile('post_image')) {
            $image = $request->file('post_image')->getClientOriginalName();
            $request->file('post_image')->storeAs('posts/' . $post->id, $image, 'public');
            $post->update(['post_image' => $image]);

            Image::make(storage_path('app/public/posts/' . $post->id . '/' . $image))
                ->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/posts/' . $post->id . '/thumbnail_' . $image));
        }

        return redirect()->route('communities.show', $community)->with('message', 'Post created successfully');
    }

    public function show($postId)
    {
        $post = Post::with('comments.user', 'community')->findOrFail($postId);
        return view('posts.show', compact('post'));
    }


    public function edit(Community $community, Post $post)
    {
        if (Gate::denies('edit-post', $post)) {
            abort(403);
        }
        return view('posts.edit', compact('community', 'post'));
    }

    public function update(StorePostRequest $request, Community $community, Post $post)
    {
        if (Gate::denies('edit-post', $post)) {
            abort(403);
        }
        $post->update($request->validated());

        if ($request->hasFile('post_image')) {

            $image = $request->file('post_image')->getClientOriginalName();

            $request->file('post_image')
                ->storeAs('posts/' . $post->id, $image, 'public');

            $url_path = storage_path('app/public/posts/' . $post->id . '/' . $post->post_image);
            $thumb_path = storage_path('app/public/posts/' . $post->id . '/thumbnail_' . $post->post_image);

            if ($post->post_image != '' && $post->post_image != $image) {
                unlink($url_path);
                unlink($thumb_path);
            }

            $post->update(['post_image' => $image]);

            Image::make(storage_path('app/public/posts/' . $post->id . '/' . $image))
                ->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/posts/' . $post->id . '/thumbnail_' . $image));
        }
        return  redirect()->route('communities.posts.show', [$community, $post])->with('message', 'Post updated successfully');
    }

    public function destroy(Community $community, Post $post)
    {
        if (Gate::denies('delete-post', $post)) {
            abort(403);
        }
        $post->delete();
        return redirect()->route('communities.show', $community)->with('message', 'Post deleted successfully');
    }
    public function vote($post_id, $vote)
    {
        $post = Post::with('community')->findOrFail($post_id);
        if (
            !PostVote::where('post_id', $post_id)->where('user_id', auth()->id())->count()
            && in_array($vote, [-1, 1])
            && $post->user_id != auth()->id()
        ) {
            PostVote::create([
                'post_id' => $post_id,
                'user_id' => auth()->id(),
                'vote' => $vote,
            ]);
        }
        return redirect()->route('communities.show', $post->community);
    }
    public function report($post_id)
    {
        $post = Post::with('community.user')->findOrFail($post_id);
        $post->community->user->notify(new PostReportNotification($post));
        return redirect()->route('communities.posts.show', [$post->community, $post])->with('message', 'Post reported successfully');
    }
}
