@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $episode->description }}</h1>

        <div class="video-player">
            <video id="video-player" width="100%" controls>
                <source src="{{ $episode->path }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <script>
            // Start playback from progress_time
            var video = document.getElementById('video-player');
            video.currentTime = {{ $episode->progress_time }};
        </script>
    </div>
@endsection
