@extends('layouts.app')
@section('content')
    <h1 class="mb-4">Your Scheduled Posts</h1>
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="draft">Draft</option>
                <option value="scheduled">Scheduled</option>
                <option value="published">Published</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Title</th>
            <th>Scheduled Time</th>
            <th>Status</th>
            <th>Platforms</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{ $post->title }}</td>
                <td>{{ $post->scheduled_time }}</td>
                <td><x-post-status-badge :status="$post->status" /></td>
                <td>{{ $post->platforms->pluck('name')->join(', ') }}</td>
                <td>
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this post?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
