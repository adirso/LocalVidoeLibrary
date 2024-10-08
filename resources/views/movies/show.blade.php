@extends('layouts.app')

@section('title', $movie->name)

@section('content')
    <h1>{{ $movie->name }}</h1>
    <p><strong>Description:</strong> {{ $movie->description }}</p>
    <p><strong>Category ID:</strong> {{ $movie->category_id }}</p>
    <p><strong>Progress Time:</strong> {{ $movie->progress_time }}</p>

    <a href="{{ route('watch', ['type' => 'movie', 'id' => $movie->id]) }}" class="btn btn-primary">Watch</a>
    <a href="{{ route('movies.edit', $movie->id) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this movie?')">Delete</button>
    </form>
    <a href="{{ route('movies.index') }}" class="btn btn-secondary">Back to Movies</a>

    <!-- Button to fetch subtitles -->
    <button class="btn btn-info" id="fetch-subtitles">Fetch Subtitles</button>

    <!-- Subtitle options (Hidden until user clicks the button) -->
    <div id="subtitle-options" style="display:none;">
        <h3>Select Subtitles:</h3>
        <ul id="subtitle-list"></ul>
    </div>

    <script>
        document.getElementById('fetch-subtitles').addEventListener('click', function () {
            fetchSubtitles({{ $movie->id }});
        });

        function fetchSubtitles(movieId) {
            fetch(`/api/fetch-subtitles/${movieId}`)
                .then(response => response.json())
                .then(data => {
                    const subtitleList = document.getElementById('subtitle-list');
                    subtitleList.innerHTML = ''; // Clear existing options
                    data.subtitles.forEach(subtitle => {
                        const listItem = document.createElement('li');
                        const downloadBtn = document.createElement('button');
                        downloadBtn.innerText = `Download (${subtitle.language})`;
                        downloadBtn.classList.add('btn', 'btn-success');
                        downloadBtn.addEventListener('click', () => downloadSubtitle(subtitle.id, movieId));
                        listItem.innerHTML = `${subtitle.filename} - ${subtitle.language}`;
                        listItem.appendChild(downloadBtn);
                        subtitleList.appendChild(listItem);
                    });
                    document.getElementById('subtitle-options').style.display = 'block';
                })
                .catch(error => console.error('Error fetching subtitles:', error));
        }

        function downloadSubtitle(subtitleId, movieId) {
            fetch(`/api/download-subtitle/${subtitleId}/${movieId}`)
                .then(response => {
                    if (response.ok) {
                        alert('Subtitle downloaded and associated with the movie.');
                    } else {
                        alert('Failed to download subtitle.');
                    }
                })
                .catch(error => console.error('Error downloading subtitle:', error));
        }
    </script>
@endsection
