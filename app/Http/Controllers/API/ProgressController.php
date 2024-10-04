<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Episode;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    /**
     * Update the progress time for a movie.
     */
    public function updateMovieProgress(Request $request, $id)
    {
        $request->validate([
            'progress_time' => 'required|integer|min:0', // Validate the input
        ]);

        $movie = Movie::findOrFail($id);
        $movie->progress_time = $request->progress_time;
        $movie->save();

        return response()->json([
            'message' => 'Movie progress updated successfully',
            'progress_time' => $movie->progress_time,
        ], 200);
    }

    /**
     * Update the progress time for an episode.
     */
    public function updateEpisodeProgress(Request $request, $id)
    {
        $request->validate([
            'progress_time' => 'required|integer|min:0',
        ]);

        $episode = Episode::findOrFail($id);
        $episode->progress_time = $request->progress_time;
        $episode->save();

        return response()->json([
            'message' => 'Episode progress updated successfully',
            'progress_time' => $episode->progress_time,
        ], 200);
    }
}
