<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Movie;
use App\Models\Series;

class VideoStreamController extends Controller
{
    /**
     * Stream the video file for movie or series.
     */
    public function stream($type, $id)
    {
        if ($type === 'movie') {
            $media = Movie::findOrFail($id);
        } elseif ($type === 'series') {
            $media = Series::findOrFail($id);
        } else {
            abort(404, 'Media type not found.');
        }

        $filePath = $media->path;

        if (!file_exists($filePath)) {
            abort(404, 'Video file not found.');
        }

        return $this->streamVideo($filePath);
    }

    /**
     * Stream the video file with HTTP range support.
     */
    private function streamVideo($filePath)
    {
        $fileSize = filesize($filePath);
        $file = fopen($filePath, 'rb');

        $start = 0;
        $length = $fileSize;
        $statusCode = 200; // Default is 200 OK
        $headers = [];

        if (isset($_SERVER['HTTP_RANGE'])) {
            $range = $_SERVER['HTTP_RANGE'];
            list($start, $end) = explode('-', substr($range, 6));

            $start = intval($start);
            $end = ($end) ? intval($end) : $fileSize - 1;

            $length = $end - $start + 1;

            fseek($file, $start);

            // Set headers for partial content (206)
            $statusCode = 206; // Partial Content
            $headers = [
                'Content-Type' => 'video/mp4',
                'Content-Range' => "bytes $start-$end/$fileSize",
                'Content-Length' => $length,
                'Accept-Ranges' => 'bytes',
            ];
        } else {
            // Set headers for a full content response
            $headers = [
                'Content-Type' => 'video/mp4',
                'Content-Length' => $length,
                'Accept-Ranges' => 'bytes',
            ];
        }

        $stream = function () use ($file, $length) {
            $buffer = 1024 * 8; // 8 KB buffer
            $bytesRemaining = $length;

            while (!feof($file) && $bytesRemaining > 0) {
                $data = fread($file, min($buffer, $bytesRemaining));
                echo $data;
                $bytesRemaining -= strlen($data);
                flush();
            }

            fclose($file);
        };

        return new StreamedResponse($stream, $statusCode, $headers);
    }
}
