<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke()
    {
        $posts = Post::with('community', 'user')->withCount(['postVotes' => function ($query) {
            $query->where('post_votes.created_at', '>', now()->subDays(7))
                ->where('vote', 1);
        }])->orderBy('post_votes_count', 'desc')->paginate(6);
        return view('home', compact('posts'));
    }
}
