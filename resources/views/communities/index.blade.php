@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">{{ __('My Communities') }}</div>

        <div class="card-body">
            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
                <br />
            @endif
            <a href="{{ route('communities.create') }}" class="btn btn-primary text-white">
                <i class="fa fa-plus"></i>
                New Community</a>
            <br /><br />
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($communities as $community)
                        <tr class="community-item">
                            <td>
                                <a href="{{ route('communities.show', $community) }}">
                                    {{ $community->name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('communities.edit', $community) }}"
                                    class="btn btn-sm btn-primary text-white">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('communities.destroy', $community) }}" method="POST"
                                    style="display: inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger text-white"
                                        onclick="return confirm('Are you sure?')">
                                        <i class="fa fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
