<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <h1>Welcome to Netflix Engine</h1>

    <h2>Last viewed movies</h2>
    @if($lastViewedMovies)
        <div class="row">
            @foreach($lastViewedMovies as $lastViewedMovie)
                <div class="col-md-3">
                    @include('movies.partials.card', ['movie' => $lastViewedMovie])
                </div>
            @endforeach
        </div>
    @else
        <p>No movies available.</p>
    @endif
    <h2>Latest Movies</h2>
    @if($latestMovies)
        <div class="row">
            @foreach($latestMovies as $movie)
                <div class="col-md-3">
                    @include('movies.partials.card', ['movie' => $movie])
                </div>
            @endforeach
        </div>
    @else
        <p>No movies available.</p>
    @endif

    <h2>Latest Series</h2>
    @if($latestSeries)
        <div class="row">
            @foreach($latestSeries as $series)
                <div class="col-md-3">
                    @include('series.partials.card', ['movie' => $series])
                </div>
            @endforeach
        </div>
    @else
        <p>No series available.</p>
    @endif

    <h2>Categories</h2>
    @if($categories)
        <ul class="list-group">
            @foreach($categories as $category)
                <li class="list-group-item">
                    <a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>No categories available.</p>
    @endif
@endsection
