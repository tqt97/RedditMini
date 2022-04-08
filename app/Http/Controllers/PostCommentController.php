<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{

    public function index()
    {
    }


    public function create()
    {
    }

    public function store(Request $request, Post $post)
    {
        $post->load('community');
        $post->comments()->create([
            'user_id' => auth()->id(),
            'comment_text' => $request->comment_text,
        ]);
        return redirect()->route('communities.posts.show', [$post->community, $post])->with('message', 'Comment created successfully');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
