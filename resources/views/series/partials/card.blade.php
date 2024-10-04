<!-- resources/views/movies/partials/card.blade.php -->
<div class="card mb-4">
    <img src="{{ $series->photo }}" class="card-img-top" alt="{{ $series->name }}">
    <div class="card-body">
        <h5 class="card-title">{{ $series->name }}</h5>
        <p class="card-text">{{ Str::limit($series->description, 100) }}</p>
        <a href="{{ route('series.show', $series->id) }}" class="btn btn-primary">View Series</a>
    </div>
</div>
