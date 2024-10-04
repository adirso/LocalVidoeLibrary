<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Series;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    /**
     * Display the list of episodes for a given series.
     */
    public function index($seriesId)
    {
        $series = Series::findOrFail($seriesId);
        $episodes = $series->episodes;

        return view('episodes.index', compact('series', 'episodes'));
    }

    /**
     * Display a single episode.
     */
    public function show($id)
    {
        $episode = Episode::findOrFail($id);

        return view('episodes.show', compact('episode'));
    }

    /**
     * Store a newly created episode.
     */
    public function store(Request $request, $seriesId)
    {
        $validated = $request->validate([
            'path' => 'required|string',
            'description' => 'required|string',
            'progress_time' => 'integer',
        ]);

        $series = Series::findOrFail($seriesId);

        $episode = new Episode($validated);
        $episode->series()->associate($series);
        $episode->save();

        return redirect()->route('episodes.index', $seriesId)->with('success', 'Episode created successfully.');
    }
}
