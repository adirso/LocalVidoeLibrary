@extends('layouts.app')

@section('title', 'Watch ' . ucfirst($type))

@section('content')
    <div class="container">
        <h1>{{ $media->name }}</h1>
        <p>{{ $media->description }}</p>

        <div class="video-player">
            <video id="video-player" width="100%" controls>
                <source src="{{ route('stream', ['type' => $type, 'id' => $media->id]) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <div class="media-info mt-3">
            @if($type === 'movie')
                <p><strong>Progress:</strong> {{ $media->progress_time }} minutes watched.</p>
            @elseif($type === 'series')
                <p><strong>Season:</strong> {{ $media->season }} | <strong>Episode:</strong> {{ $media->episode }}</p>
                <p><strong>Progress:</strong> {{ $media->progress_time }} minutes watched.</p>
            @endif
        </div>
    </div>
@endsection
