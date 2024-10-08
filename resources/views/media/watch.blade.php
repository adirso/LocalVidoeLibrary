@extends('layouts.app')

@section('title', sprintf('Watch %s', $media->name) . ucfirst($type))

@section('content')
    <div class="container">
        <h1>{{ $media->name }}</h1>
        <p>{{ $media->description }}</p>

        <div class="video-player">
            <video id="video-player" width="100%" controls>
                <source src="{{ route('stream', ['type' => $type, 'id' => $media->id]) }}" type="video/mp4">
                @foreach($media->captions as $caption)
                    <track src="{{ asset('storage/' . $caption->path) }}" kind="subtitles" srclang="{{ $caption->language }}" label="{{ ucfirst($caption->language) }}">
                @endforeach
                Your browser does not support the video tag.
            </video>
        </div>

        <div class="media-info mt-3">
            @if($type === 'movie')
                <p><strong>Progress:</strong> {{ floor($media->progress_time / 60) }}:{{ str_pad($media->progress_time % 60, 2, '0', STR_PAD_LEFT) }} minutes watched.</p>
            @elseif($type === 'series')
                <p><strong>Season:</strong> {{ $media->season }} | <strong>Episode:</strong> {{ $media->episode }}</p>
                <p><strong>Progress:</strong> {{ $media->progress_time }} minutes watched.</p>
            @endif
        </div>
    </div>

    <script>
        // Start playback from progress_time
        var video = document.getElementById('video-player');
        video.currentTime = {{ $progressTime }};
    </script>

    <script>
        var video = document.getElementById('video-player');
        var mediaType = '{{ $type }}'; // 'movie' or 'episode'
        var mediaId = '{{ $media->id }}'; // movie or episode ID
        var progressInterval;

        // Function to update progress via API
        function updateProgress() {
            var currentTime = Math.floor(video.currentTime); // Get current playback time in seconds
            var apiUrl = '';

            if (mediaType === 'movie') {
                apiUrl = `/api/movies/${mediaId}/progress`;
            } else if (mediaType === 'episode') {
                apiUrl = `/api/episodes/${mediaId}/progress`;
            }

            fetch(apiUrl, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    progress_time: currentTime
                })
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Progress updated:', data);
                })
                .catch(error => {
                    console.error('Error updating progress:', error);
                });
        }

        // Start updating progress every 60 seconds
        function startProgressUpdates() {
            if (!progressInterval) {
                progressInterval = setInterval(updateProgress, 60000); // Every 60 seconds
            }
        }

        // Stop updating progress
        function stopProgressUpdates() {
            if (progressInterval) {
                clearInterval(progressInterval);
                progressInterval = null;
            }
            updateProgress(); // Update progress one last time when stopping
        }

        // Start updating progress when video starts playing
        video.addEventListener('play', startProgressUpdates);

        // Stop updating progress when video is paused or ends
        video.addEventListener('pause', stopProgressUpdates);
        video.addEventListener('ended', stopProgressUpdates);
    </script>


@endsection
