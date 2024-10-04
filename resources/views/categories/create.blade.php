<!-- resources/views/categories/create.blade.php -->
@extends('layouts.app')

@section('title', 'Add New Category')

@section('content')
    <h1>Add New Category</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        @include('categories.partials.form', ['submitButtonText' => 'Add Category'])
    </form>
@endsection
