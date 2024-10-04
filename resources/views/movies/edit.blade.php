<!-- resources/views/movies/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Movie')

@section('content')
    <h1>Edit Movie</h1>

    <form action="{{ route('movies.update', $movie->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('movies.partials.form', ['submitButtonText' => 'Update Movie'])
    </form>
@endsection
