@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Your Posts</h1>

        {{-- Filter Form --}}
        <form id="filterForm" method="GET" class="row mb-4">
            <div class="col-md-3">
                <select name="status" class="form-select" id="statusFilter">
                    <option value="">All Statuses</option>
                    <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Draft</option>
                    <option value="3" {{ request('status') == 3 ? 'selected' : '' }}>Scheduled</option>
                    <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="date" id="dateFilter" class="form-control" value="{{ request('date') }}">
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter">filter</i>
                </button>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <a href="{{ route('posts.index') }}" class="btn btn-secondary w-100">
                    <i class="fas fa-times">reset</i>
                </a>
            </div>
        </form>

        {{-- Posts Table --}}
        <table class="table table-bordered" id="postsTable">
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
            @forelse($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->scheduled_time }}</td>
                    <td>
                        <span class="badge bg-info text-dark">{{ ucfirst($post->status) }}</span>
                    </td>
                    <td>{{ $post->platforms->pluck('name')->join(', ') }}</td>
                    <td>
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this post?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No posts found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        const indexRoute = @json(route('posts.index'));

        $(document).ready(function () {
            $('#filterForm').on('submit', function (e) {
                e.preventDefault();
                const status = $('#statusFilter').val();
                const date = $('#dateFilter').val();
                window.location.href = `${indexRoute}?status=${status}&date=${date}`;
            });
        });
    </script>
@endsection
