<!-- resources/views/series/index.blade.php -->
@extends('layouts.app')

@section('title', 'Series')

@section('content')
    <h1>Series</h1>
    <a href="{{ route('series.create') }}" class="btn btn-primary mb-3">Add New Series</a>

    @if($seriesList)
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Season</th>
                <th>Episode</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($seriesList as $series)
                <tr>
                    <td>{{ $series->name }}</td>
                    <td>{{ $series->season }}</td>
                    <td>{{ $series->episode }}</td>
                    <td>{{ $series->category_id }}</td>
                    <td>
                        <a href="{{ route('series.show', $series->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('series.edit', $series->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('series.destroy', $series->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this series?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>No series found.</p>
    @endif
@endsection
