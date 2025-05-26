@extends('layouts.app')
@section('content')
    <h1 class="mb-4">Create New Post</h1>
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea name="content" id="content" class="form-control" rows="4" required></textarea>
            <div class="form-text" id="char-count">0 characters</div>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image (optional)</label>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Select Platforms</label>
            <select name="platforms[]" class="form-select" multiple required>
                @foreach($platforms as $platform)
                    <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="scheduled_time" class="form-label">Schedule Time</label>
            <input type="datetime-local" name="scheduled_time" class="form-control" required>
        </div>
        <button class="btn btn-primary">Schedule Post</button>
    </form>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const textarea = document.getElementById('content');
            const counter = document.getElementById('char-count');
            textarea?.addEventListener('input', () => {
                counter.textContent = textarea.value.length + ' characters';
            });
        });
    </script>
@endpush
