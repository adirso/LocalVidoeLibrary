<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Movie;
use App\Models\Series;
use Illuminate\Http\Request;

class MovieSeriesController extends Controller
{
    public function watch($type, $id)
    {
        if ($type === 'movie') {
            $media = Movie::findOrFail($id);
        } elseif ($type === 'series') {
            $media = Series::findOrFail($id);
            // Optionally, fetch the first episode or pass the series to a separate episode controller
        } elseif ($type === 'episode') {
            $media = Episode::findOrFail($id); // Add this for episodes
        } else {
            abort(404, 'Media type not found.');
        }

        // Video URL from path
        $url = $media->path;

        return view('media.watch', [
            'type' => $type,
            'media' => $media,
            'videoUrl' => $url,
            'progressTime' => $media->progress_time, // Send progress_time to the view
        ]);
    }

}
