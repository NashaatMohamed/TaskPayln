<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Content Scheduler') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Content Scheduler</a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('posts.create') }}">New Post</a></li>
{{--            <li class="nav-item"><a class="nav-link" href="{{ route('settings.platforms') }}">Settings</a></li>--}}
{{--            <li class="nav-item">--}}
{{--                <form action="{{ route('logout') }}" method="POST" class="d-inline">@csrf <button class="btn btn-link nav-link" type="submit">Logout</button></form>--}}
{{--            </li> --}}

{{--            <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>--}}
{{--            <li class="nav-item"><a class="nav-link" href="#">New Post</a></li>--}}
            <li class="nav-item"><a class="nav-link" href="#">Settings</a></li>
            <li class="nav-item">
                <form action="#" method="POST" class="d-inline">@csrf <button class="btn btn-link nav-link" type="submit">Logout</button></form>
            </li>
        </ul>
    </div>
</nav>
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @yield('content')
</div>
@stack('scripts')
</body>
</html>
