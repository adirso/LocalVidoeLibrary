<!-- resources/views/movies/partials/card.blade.php -->
<div class="card mb-4">
    <img src="{{ $movie->photo }}" class="card-img-top" alt="{{ $movie->name }}">
    <div class="card-body">
        <h5 class="card-title">{{ $movie->name }}</h5>
        <p class="card-text">{{ Str::limit($movie->description, 100) }}</p>
        <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-primary">View Movie</a>
    </div>
</div>
