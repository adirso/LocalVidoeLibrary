@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Episodes for {{ $series->name }}</h1>
        <ul>
            @foreach ($episodes as $episode)
                <li>
                    <a href="{{ route('episodes.show', $episode->id) }}">{{ $episode->description }}</a>
                    <p>Progress: {{ $episode->progress_time }} seconds</p>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
