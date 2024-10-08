<?php
//
//namespace App\Console\Commands;
//
//use Illuminate\Console\Command;
//use Illuminate\Support\Facades\File;
//use NetflixEngine\Series\SeriesService;
//use NetflixEngine\Series\SeasonService;
//use NetflixEngine\Series\EpisodeService;
//
//class seriesScan extends Command
//{
//    /**
//     * The name and signature of the console command.
//     *
//     * @var string
//     */
//    protected $signature = 'app:series-scan';
//
//    /**
//     * The console command description.
//     *
//     * @var string
//     */
//    protected $description = 'Scan the series folder, add series, seasons, and episodes to the database.';
//
//    /**
//     * Supported video formats.
//     *
//     * @var array
//     */
//    protected $supportedFormats = ['mp4', 'mkv', 'avi', 'mov'];
//
//    /**
//     * Services for series, seasons, and episodes.
//     *
//     * @var SeriesService
//     * @var SeasonService
//     * @var EpisodeService
//     */
//    protected $seriesService;
//    protected $seasonService;
//    protected $episodeService;
//
//    /**
//     * Constructor to inject the services.
//     */
//    public function __construct(SeriesService $seriesService, SeasonService $seasonService, EpisodeService $episodeService)
//    {
//        parent::__construct();
//
//        $this->seriesService = $seriesService;
//        $this->seasonService = $seasonService;
//        $this->episodeService = $episodeService;
//    }
//
//    /**
//     * Execute the console command.
//     */
//    public function handle()
//    {
//        // Get the series path from the .env file
//        $seriesPath = env('SERIES_PATH');
//
//        if (!is_dir($seriesPath)) {
//            $this->error("The directory $seriesPath does not exist.");
//            return;
//        }
//
//        // Scan the directory for series folders
//        $this->info("Scanning series directory: $seriesPath");
//        $seriesFolders = $this->scanSeriesDirectory($seriesPath);
//
//        if (empty($seriesFolders)) {
//            $this->info("No series folders found.");
//            return;
//        }
//
//        foreach ($seriesFolders as $seriesFolder) {
//            $this->processSeries($seriesFolder);
//        }
//
//        $this->info("Series scanning complete.");
//    }
//
//    /**
//     * Scan the series directory for series folders.
//     *
//     * @param string $directory
//     * @return array
//     */
//    protected function scanSeriesDirectory($directory)
//    {
//        return File::directories($directory); // Get all directories in the series directory
//    }
//
//    /**
//     * Process each series folder, scan for seasons and episodes.
//     *
//     * @param string $seriesFolder
//     */
//    protected function processSeries($seriesFolder)
//    {
//        // Extract series name from folder name
//        $seriesName = basename($seriesFolder);
//
//        // Add the series using SeriesService
//        $series = $this->seriesService->createSeries(['name' => $seriesName]);
//
//        $this->info("Processing series: $seriesName");
//
//        // Scan for season folders within the series
//        $seasonFolders = File::directories($seriesFolder);
//
//        foreach ($seasonFolders as $seasonFolder) {
//            $this->processSeason($series->id, $seasonFolder);
//        }
//    }
//
//    /**
//     * Process each season folder, scan for episodes.
//     *
//     * @param int $seriesId
//     * @param string $seasonFolder
//     */
//    protected function processSeason($seriesId, $seasonFolder)
//    {
//        // Extract season number from folder name
//        $seasonNumber = basename($seasonFolder);
//
//        // Add the season using SeasonService
//        $season = $this->seasonService->createSeason([
//            'number' => $seasonNumber,
//            'series_id' => $seriesId
//        ]);
//
//        $this->info("Processing season: $seasonNumber");
//
//        // Scan for episode files within the season folder
//        $episodeFiles = File::files($seasonFolder);
//
//        foreach ($episodeFiles as $episodeFile) {
//            // Check if the file extension is a supported video format
//            if (in_array($episodeFile->getExtension(), $this->supportedFormats)) {
//                $this->processEpisode($season->id, $episodeFile);
//            }
//        }
//    }
//
//    /**
//     * Process each episode file and add it to the database.
//     *
//     * @param int $seasonId
//     * @param string $episodeFile
//     */
//    protected function processEpisode($seasonId, $episodeFile)
//    {
//        // Extract episode name from file name
//        $episodeName = basename($episodeFile->getFilename(), '.' . $episodeFile->getExtension());
//
//        // Add the episode using EpisodeService
//        $episode = $this->episodeService->createEpisode([
//            'path' => $episodeFile->getPathname(),
//            'description' => "Auto-scanned episode", // Default description
//            'progress_time' => 0, // Start with no progress
//            'season_id' => $seasonId,
//        ]);
//
//        $this->info("Processing episode: $episodeName");
//    }
//}
