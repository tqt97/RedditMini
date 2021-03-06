<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommunityRequest;
use App\Http\Requests\UpdateCommunityRequest;
use App\Models\Community;
use App\Models\Topic;

class CommunityController extends Controller
{

    public function index()
    {
        $communities = Community::where('user_id', auth()->id())->get();
        return view('communities.index', compact('communities'));
    }

    public function create()
    {
        $topics = Topic::all();
        return view('communities.create', compact('topics'));
    }

    public function store(StoreCommunityRequest $request)
    {
        $community = Community::create($request->validated() + ['user_id' => auth()->id()]);
        $community->topics()->attach($request->topics);
        return redirect()->route('communities.show', $community)->with('message', 'Community created successfully');
    }

    public function show($slug)
    {
        $community = Community::where('slug', $slug)->firstOrFail();

        $query = $community->posts()->with('postVotes');
        if (request('sort', '') == 'popular') {
            $query->orderBy('votes', 'desc');
        } else {
            $query->latest('id');
        }
        $posts = $query->paginate(10);

        return view('communities.show', compact('community', 'posts'));
    }

    public function edit(Community $community)
    {
        if ($community->user_id != auth()->id()) {
            abort(403);
        }
        $topics = Topic::all();
        $community->load('topics');
        return view('communities.edit', compact('community', 'topics'))->with('message', 'Community updated successfully');
    }


    public function update(UpdateCommunityRequest $request, Community $community)
    {
        $community->update($request->validated());
        $community->topics()->sync($request->topics);
        return redirect()->route('communities.index');
    }


    public function destroy(Community $community)
    {
        if ($community->user_id != auth()->id()) {
            abort(403);
        }
        $community->delete();
        return redirect()->route('communities.index')->with('message', 'Community deleted successfully');
    }
}
