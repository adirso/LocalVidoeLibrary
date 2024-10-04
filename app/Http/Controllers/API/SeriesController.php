<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Series;
use Illuminate\Http\Request;
use App\Http\Resources\SeriesResource;
use Illuminate\Http\JsonResponse;

class SeriesController extends Controller
{
    /**
     * Display a listing of series.
     */
    public function index(): JsonResponse
    {
        $series = Series::all();
        return response()->json(SeriesResource::collection($series));
    }

    /**
     * Store a newly created series in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'required|string',
            'path' => 'required|string',
            'season' => 'required|integer',
            'episode' => 'required|integer',
            'progress_time' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        $series = Series::create($validatedData);

        return response()->json(new SeriesResource($series), 201);
    }

    /**
     * Display the specified series.
     */
    public function show(Series $series): JsonResponse
    {
        return response()->json(new SeriesResource($series));
    }

    /**
     * Update the specified series in storage.
     */
    public function update(Request $request, Series $series): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'photo' => 'sometimes|string',
            'path' => 'sometimes|string',
            'season' => 'sometimes|integer',
            'episode' => 'sometimes|integer',
            'progress_time' => 'sometimes|integer',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        $series->update($validatedData);

        return response()->json(new SeriesResource($series));
    }

    /**
     * Remove the specified series from storage.
     */
    public function destroy(Series $series): JsonResponse
    {
        $series->delete();
        return response()->json(null, 204);
    }
}
