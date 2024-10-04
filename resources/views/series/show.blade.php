<!-- resources/views/series/show.blade.php -->
@extends('layouts.app')

@section('title', $series->name)

@section('content')
    <h1>{{ $series->name }}</h1>
    <p><strong>Description:</strong> {{ $series->description }}</p>
    <p><strong>Season:</strong> {{ $series->season }}</p>
    <p><strong>Episode:</strong> {{ $series->episode }}</p>
    <p><strong>Category ID:</strong> {{ $series->category_id }}</p>

    <a href="{{ route('series.edit', $series->id) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('series.destroy', $series->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this series?')">Delete</button>
    </form>
    <a href="{{ route('series.index') }}" class="btn btn-secondary">Back to Series</a>
@endsection
