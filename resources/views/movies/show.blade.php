<!-- resources/views/movies/show.blade.php -->
@extends('layouts.app')

@section('title', $movie->name)

@section('content')
    <h1>{{ $movie->name }}</h1>
    <p><strong>Description:</strong> {{ $movie->description }}</p>
    <p><strong>Category ID:</strong> {{ $movie->category_id }}</p>
    <p><strong>Progress Time:</strong> {{ $movie->progress_time }}</p>

    <a href="{{ route('movies.edit', $movie->id) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this movie?')">Delete</button>
    </form>
    <a href="{{ route('movies.index') }}" class="btn btn-secondary">Back to Movies</a>
@endsection
