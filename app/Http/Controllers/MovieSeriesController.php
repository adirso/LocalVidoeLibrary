<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Series;
use Illuminate\Http\Request;

class MovieSeriesController extends Controller
{
    /**
     * Display the player for a movie or series.
     */
    public function watch($type, $id)
    {
        if ($type === 'movie') {
            $media = Movie::findOrFail($id);
        } elseif ($type === 'series') {
            $media = Series::findOrFail($id);
        } else {
            abort(404, 'Media type not found.');
        }

        return view('media.watch', [
            'type' => $type,
            'media' => $media,
        ]);
    }
}
