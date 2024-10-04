<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Resources\MovieResource;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
    /**
     * Display a listing of movies.
     */
    public function index(): JsonResponse
    {
        $movies = Movie::all();
        return response()->json(MovieResource::collection($movies));
    }

    /**
     * Store a newly created movie in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'required|string',
            'path' => 'required|string',
            'progress_time' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        $movie = Movie::create($validatedData);

        return response()->json(new MovieResource($movie), 201);
    }

    /**
     * Display the specified movie.
     */
    public function show(Movie $movie): JsonResponse
    {
        return response()->json(new MovieResource($movie));
    }

    /**
     * Update the specified movie in storage.
     */
    public function update(Request $request, Movie $movie): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'photo' => 'sometimes|string',
            'path' => 'sometimes|string',
            'progress_time' => 'sometimes|integer',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        $movie->update($validatedData);

        return response()->json(new MovieResource($movie));
    }

    /**
     * Remove the specified movie from storage.
     */
    public function destroy(Movie $movie): JsonResponse
    {
        $movie->delete();
        return response()->json(null, 204);
    }
}
