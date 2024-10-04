<!-- resources/views/series/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Series')

@section('content')
    <h1>Edit Series</h1>

    <form action="{{ route('series.update', $series->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('series.partials.form', ['submitButtonText' => 'Update Series'])
    </form>
@endsection
