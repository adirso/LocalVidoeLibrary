<?php

namespace App\Console\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use GuzzleHttp\Client;
use App\Models\Movie;

class moviesScan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:movies-scan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan the movies folder and add movies to the database using TheMovieDB API.';

    protected array $releaseTags = [
        '1080p', '720p', '480p', 'BRRip', 'BluRay', 'HDRip', 'DVDRip', 'WEBRip', 'WEB DL', 'WEB-DL',
        'XviD', 'x264', 'H264', 'AC3', 'AAC', 'AAC2 0', 'AAC 2 0', 'DTS', 'YIFY', 'RARBG', 'EVO',
        'Ganool', 'ShAaNiG', 'ETRG', 'Esub', 'Subbed', 'Subs', 'HEVC', 'H265', 'H 265',
        'EXTENDED', 'UNRATED', 'Directors Cut', 'Dual Audio', 'Eng Dub',
        'Hindi', 'Korean', 'HC', 'HC HDRip', 'CAM', 'TS', 'SCREENER', 'DVDSCR',
        'R5', 'LiNE', 'INSPiRAL', 'HeBSuB', 'TaMiToS', 'Www', 'Nako',
        'New', 'Line', 'juggs', 'YTS.AG', 'YTS', 'IMAX',
    ];


    /**
     * Supported video formats.
     *
     * @var array
     */
    protected array $supportedFormats = ['mp4', 'mkv', 'avi', 'mov'];

    /**
     * TheMovieDB API base URL.
     *
     * @var string
     */
    protected string $tmdbApiBaseUrl = 'https://api.themoviedb.org/3/search/movie';

    /**
     * TheMovieDB API Key.
     *
     * @var string
     */
    protected mixed $tmdbApiKey;

    /**
     * HTTP Client for making API requests.
     *
     * @var Client
     */
    protected Client $client;

    protected \getID3 $getID3;

    /**
     * Constructor to initialize HTTP client and API key.
     */
    public function __construct()
    {
        parent::__construct();

        $this->client = new Client();
        $this->tmdbApiKey = env('TMDB_API_KEY');
        $this->getID3 = new \getID3();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the movies path from the .env file
        $moviesPath = env('MOVIES_PATH');

        if (!is_dir($moviesPath)) {
            $this->error("The directory $moviesPath does not exist.");
            return;
        }

        // Scan the directory for movie files
        $this->info("Scanning directory: $moviesPath");
        $movieFiles = $this->scanMoviesDirectory($moviesPath);

        if (empty($movieFiles)) {
            $this->info("No movie files found.");
            return;
        }

        foreach ($movieFiles as $moviePath) {
            if ($this->isMovie($moviePath)) {
                $this->processMovie($moviePath);
            }
        }

        $this->info("Movie scanning complete.");
    }

    /**
     * Scan the directory for movie files.
     *
     * @param string $directory
     * @return array
     */
    protected function scanMoviesDirectory($directory): array
    {
        $files = File::allFiles($directory);

        $movieFiles = [];

        foreach ($files as $file) {
            // Check if the file extension is a supported movie format
            if (in_array($file->getExtension(), $this->supportedFormats)) {
                $movieFiles[] = $file->getPathname(); // Full path to the file
            }
        }

        return $movieFiles;
    }

    /**
     * Process a movie file and add it to the database.
     *
     * @param string $moviePath
     */
    protected function processMovie($moviePath): void
    {
        // Get the directory name of the movie file
        $movieDirectory = dirname($moviePath);

        // Get the folder name (last part of the directory path)
        $rawFolderName = basename($movieDirectory);

        // Clean the folder name to get the movie name
        $movieName = $this->cleanMovieName($rawFolderName);

        $this->info("Processing file: $moviePath");
        $this->info("Extracted movie name from folder: $movieName");

        // Fetch movie details from TheMovieDB API
        $movieData = $this->fetchMovieFromTMDB($movieName);

        if ($movieData) {
            // Add movie to the database
            $this->addMovieToDatabase($movieData, $moviePath);
        } else {
            $this->info("No data found on TMDB for movie: $movieName");
        }
    }

    /**
     * Fetch movie data from TheMovieDB API by name.
     *
     * @param string $movieName
     * @return array|null
     * @throws GuzzleException
     */
    protected function fetchMovieFromTMDB(string $movieName): ?array
    {
        $url = $this->tmdbApiBaseUrl . '?query=' . urlencode($movieName) . '&api_key=' . $this->tmdbApiKey;

        try {
            $response = $this->client->get($url);
            $data = json_decode($response->getBody(), true);

            if (isset($data['results']) && count($data['results']) > 0) {
                return $data['results'][0]; // Return the first movie match
            }

            return null; // No match found
        } catch (\Exception $e) {
            $this->error("Error fetching data from TMDB: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Add a movie to the database.
     *
     * @param array $movieData
     * @param string $moviePath
     */
    protected function addMovieToDatabase(array $movieData, string $moviePath): void
    {
        // Prepare movie data for saving
        $movie = Movie::create([
            'name' => $movieData['title'],
            'description' => $movieData['overview'] ?? 'Description not available',
            'photo' => $movieData['poster_path'] ? 'https://image.tmdb.org/t/p/w500/' . $movieData['poster_path'] : '',
            'path' => $moviePath,
            'progress_time' => 0, // Default progress
            'category_id' => 1, // Default category, modify as needed
        ]);

        $this->info("Movie '{$movie->name}' added to the database. Path: {$movie->path}");
    }

    /**
     * Clean the movie name extracted from the file or folder name.
     *
     * @param string $name
     * @return string
     */
    protected function cleanMovieName(string $name): string
    {
        // Remove file extension if any
        $name = pathinfo($name, PATHINFO_FILENAME);

        // Replace underscores and hyphens with spaces
        $name = str_replace(['_', '-'], ' ', $name);

        // Remove text within square brackets and parentheses
        $name = preg_replace('/[\[\(][^\[\]\(\)]*[\]\)]/', '', $name);

        // Remove unwanted special characters (except letters, numbers, and spaces)
        $name = preg_replace('/[^a-zA-Z0-9\s.]/', '', $name);

        // Handle abbreviations like V.H.S -> VHS by removing periods between uppercase letters
        $name = preg_replace('/(?<=\b[A-Z])\.(?=[A-Z])/', '', $name);

        // Replace periods between lowercase/uppercase words with spaces (e.g., 22.Jump.Street -> 22 Jump Street)
        $name = preg_replace('/(?<=\w)\.(?=\w)/', ' ', $name);

        // Avoid splitting all-uppercase words like BRRip, IMAX, etc.
        $name = preg_replace('/(?<=[a-z])(?=[A-Z])/', ' ', $name);

        // Replace multiple spaces with a single space
        $name = preg_replace('/\s+/', ' ', $name);

        // Trim leading and trailing whitespace
        $name = trim($name);

        // Prepare a combined pattern of release tags, resolutions, and years surrounded by word boundaries
        $releaseTagsPattern = implode('|', array_map('preg_quote', $this->releaseTags));
        $combinedPattern = '/\b(' . $releaseTagsPattern . '|\d{3,4}p\b|(19|20)\d{2})\b.*/i';

        // Remove everything after the first occurrence of a release tag, resolution, or year
        if (preg_match($combinedPattern, $name, $matches, PREG_OFFSET_CAPTURE)) {
            $name = substr($name, 0, $matches[0][1]);
        }

        // Replace multiple spaces with a single space again
        $name = preg_replace('/\s+/', ' ', $name);

        // Trim any remaining whitespace
        $name = trim($name);

        return $name;
    }

    /**
     * @param $filePath
     * @return bool
     */
    private function isMovie($filePath): bool
    {
        // Analyze the file
        $fileInfo = $this->getID3->analyze($filePath);

        // If the file is a video and has a duration, get the playtime in seconds
        if (isset($fileInfo['playtime_seconds'])) {
            $duration = $fileInfo['playtime_seconds'];

            // Check if the duration is more than 60 minutes (3600 seconds)
            return $duration > 3600;
        }

        // If we can't get the duration, assume it's not a movie
        return false;
    }

}
