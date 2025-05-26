@props(['status'])
@php
    $class = match($status) {
        'draft' => 'badge bg-secondary',
        'scheduled' => 'badge bg-info',
        'published' => 'badge bg-success',
        default => 'badge bg-dark'
    };
@endphp
<span class="{{ $class }}">{{ ucfirst($status) }}</span>
