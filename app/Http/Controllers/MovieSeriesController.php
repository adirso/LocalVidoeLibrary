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
            $media = Movie::with('captions')->findOrFail($id);
        } elseif ($type === 'series') {
            $media = Series::findOrFail($id);
        } elseif ($type === 'episode') {
            $media = Episode::findOrFail($id);
        } else {
            abort(404, 'Media type not found.');
        }

        $url = $media->path;

        return view('media.watch', [
            'type' => $type,
            'media' => $media,
            'videoUrl' => $url,
            'progressTime' => $media->progress_time,
        ]);
    }

}
