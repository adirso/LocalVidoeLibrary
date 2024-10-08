<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use NetflixEngine\Movie\MovieService;


class SubtitleController extends Controller
{
    private string $openSubtitlesApiKey;
    private MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
        $this->openSubtitlesApiKey = env('SUBTITLES_API_KEY');
    }

    public function fetchSubtitles($movieId)
    {
        $movie = $this->movieService->getMovieById($movieId);
        $movieTitle = pathinfo($movie->path, PATHINFO_FILENAME);

        $client = new Client();
        $response = $client->get('https://api.opensubtitles.com/api/v1/subtitles', [
            'headers' => [
                'Api-Key' => $this->openSubtitlesApiKey,
                'User-Agent' => 'Adir',
            ],
            'query' => [
                'query' => $movieTitle,
                'languages' => 'en,he',
            ],
        ]);

        $subtitles = json_decode($response->getBody()->getContents())->data;

        return response()->json([
            'subtitles' => array_map(function ($subtitle) {
                return [
                    'id' => $subtitle->attributes->files[0]->file_id,
                    'filename' => $subtitle->attributes->files[0]->file_name,
                    'language' => $subtitle->attributes->language,
                ];
            }, $subtitles),
        ]);
    }

    public function downloadSubtitle($subtitleId, $movieId)
    {
        $client = new Client();

        try {
            $response = $client->post("https://api.opensubtitles.com/api/v1/download", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Api-Key' => $this->openSubtitlesApiKey,
                    'Content-Type' => 'application/json',
                    'User-Agent' => 'Adir',
                ],
                'json' => [
                    'file_id' => $subtitleId, // Pass the subtitle ID as required
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $subtitleData = json_decode($response->getBody()->getContents());

                // Fetch the actual subtitle content from the returned URL
                $subtitleContent = file_get_contents($subtitleData->link);
                $subtitleContentVTT = $this->convertSrtToVtt($subtitleContent);
                $filePath = "movies/{$movieId}/subtitles/{$subtitleData->file_name}";

                // Store the subtitle content in the desired path
                Storage::disk('public')->put($filePath, $subtitleContentVTT);

                // Insert subtitle data into the database
                \DB::table('subtitles')->insert([
                    'movie_id' => $movieId,
                    'path' => $filePath,
                    'language' => '',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Subtitle downloaded and saved.',
                ]);
            } else {
                \Log::error("Failed to download subtitle. Response: " . $response->getBody()->getContents());
                return response()->json(['error' => 'Failed to download subtitle.'], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            \Log::error("Error occurred: " . $e->getMessage());
            return response()->json(['error' => 'Error downloading subtitle.'], 500);
        }
    }

    private function convertSrtToVtt($srtContent)
    {
        // Convert the SRT content to VTT format
        $vttContent = "WEBVTT\n\n"; // Add the VTT header

        // Replace SRT time format with VTT-compatible time format
        $vttContent .= preg_replace(
            '/(\d{2}):(\d{2}):(\d{2}),(\d{3})/',
            '$1:$2:$3.$4',
            $srtContent
        );

        return $vttContent;
    }
}
