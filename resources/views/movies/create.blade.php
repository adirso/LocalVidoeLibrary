<!-- resources/views/movies/create.blade.php -->
@extends('layouts.app')

@section('title', 'Add New Movie')

@section('content')
    <h1>Add New Movie</h1>

    <form action="{{ route('movies.store') }}" method="POST">
        @csrf
        @include('movies.partials.form', ['submitButtonText' => 'Add Movie'])
    </form>
@endsection
