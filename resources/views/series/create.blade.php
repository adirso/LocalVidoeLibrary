<!-- resources/views/series/create.blade.php -->
@extends('layouts.app')

@section('title', 'Add New Series')

@section('content')
    <h1>Add New Series</h1>

    <form action="{{ route('series.store') }}" method="POST">
        @csrf
        @include('series.partials.form', ['submitButtonText' => 'Add Series'])
    </form>
@endsection
