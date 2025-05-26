@extends('layouts.app')
@section('content')
    <h1 class="mb-4">Manage Platforms</h1>
    <form action="{{ route('settings.platforms.update') }}" method="POST">
        @csrf @method('PUT')
        @foreach($platforms as $platform)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="platforms[]" value="{{ $platform->id }}"
                       id="platform-{{ $platform->id }}" @checked(in_array($platform->id, $userPlatforms))>
                <label class="form-check-label" for="platform-{{ $platform->id }}">
                    {{ $platform->name }}
                </label>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary mt-3">Save Settings</button>
    </form>
@endsection
