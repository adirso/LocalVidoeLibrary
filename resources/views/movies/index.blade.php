<!-- resources/views/movies/index.blade.php -->
@extends('layouts.app')

@section('title', 'Movies')

@section('content')
    <h1>Movies</h1>
    <a href="{{ route('movies.create') }}" class="btn btn-primary mb-3">Add New Movie</a>

    @if($movies)
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Progress Time</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($movies as $movie)
                <tr>
                    <td>{{ $movie->name }}</td>
                    <td>{{ $movie->description }}</td>
                    <td>{{ $movie->category_id }}</td>
                    <td>{{ $movie->progress_time }}</td>
                    <td>
                        <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('movies.edit', $movie->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this movie?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>No movies found.</p>
    @endif
@endsection
