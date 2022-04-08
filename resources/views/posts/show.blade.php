@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3> {{ $post->title }} </h3>
        </div>

        <div class="card-body">
            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            @if ($post->post_url != '')
                <div class="mb-2">
                    <a href="{{ $post->post_url }}" target="_blank">{{ $post->post_url }}</a>
                </div>
            @endif
            @if ($post->post_image != '')
                <img src="{{ asset('storage/posts/' . $post->id . '/thumbnail_' . $post->post_image) }}"
                    class="img-responsive w-100" />
                <br /><br />
            @endif
            {{ $post->post_text }}
            @auth
                <hr>
                <h3 class="mt-3">Comments</h3>
                @forelse ($post->comments as $comment)
                    <div class="my-1">
                        <p class="my-1">{{ $comment->comment_text }}</p>
                        <p>
                            <i class="fa fa-user"></i>
                            <b>{{ $comment->user->name }}</b>
                            <i class="fa fa-clock"></i>
                            {{ $comment->created_at->diffForHumans() }}
                        </p>
                    </div>
                @empty
                    <p>No comments yet</p>
                @endforelse
                <hr>
                <form action="{{ route('posts.comments.store', [$post]) }}" method="POST">
                    @csrf
                    <div class="form-group my-3">
                        <label for="comment">Your comment</label>
                        <textarea class="form-control mt-1" name="comment_text" id="comment_text" rows="2" required></textarea></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary text-white">Submit</button>
                </form>
                <br />
                <div class="mt-2">
                    @can('edit-post', $post)
                        <a href="{{ route('communities.posts.edit', [$post->community, $post]) }}" class="text-white">
                            <button class="btn btn-primary  btn-sm text-white">
                                <i class="fa fa-edit"></i>
                            </button>
                        </a>
                    @endcan

                    @can('delete-post', $post)
                        <form action="{{ route('communities.posts.destroy', [$post->community, $post]) }}" method="POST"
                            style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger text-white"
                                onclick="return confirm('Are you sure?')">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('post.report', $post->id) }}" method="POST" style="display: inline-block">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger text-white"
                                onclick="return confirm('Are you sure to report this post ?')">
                                <i class="fa fa-exclamation-triangle"></i> Report
                            </button>
                        </form>
                    @endcan
                </div>
            @endauth
        </div>
    </div>
@endsection
