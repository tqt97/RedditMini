@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>
                {{ __('Most popular') }}
            </h3>
        </div>

        <div class="card-body">
            @foreach ($posts as $post)
                <div class="row">
                    @livewire('post-votes', ['post' => $post])
                    <div class="col-11">
                        {{-- {{ $post->post_votes_count }} --}}
                        <a href="{{ route('communities.posts.show', [$post->id]) }}">
                            <h2>{{ $post->title }}</h2>
                        </a>
                        <p>
                            <i class="fa fa-clock mr-2"></i> {{ $post->created_at->diffForHumans() }}
                            <br />
                            <i class="fa fa-user mr-2"></i> {{ $post->user->name }}
                        </p>
                        <p>{{ \Illuminate\Support\Str::words($post->post_text, 10) }}</p>
                    </div>
                </div>
                <hr />
            @endforeach
        </div>
        {{ $posts->links() }}
    </div>
@endsection
