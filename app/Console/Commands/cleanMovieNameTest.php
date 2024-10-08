<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class cleanMovieNameTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-movie-name-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $releaseTags = [
        '1080p', '720p', '480p', 'BRRip', 'BluRay', 'HDRip', 'DVDRip', 'WEBRip', 'WEB DL', 'WEB-DL',
        'XviD', 'x264', 'H264', 'AC3', 'AAC', 'AAC2 0', 'AAC 2 0', 'DTS', 'YIFY', 'RARBG', 'EVO',
        'Ganool', 'ShAaNiG', 'ETRG', 'Esub', 'Subbed', 'Subs', 'HEVC', 'H265', 'H 265',
        'EXTENDED', 'UNRATED', 'Directors Cut', 'Dual Audio', 'Eng Dub',
        'Hindi', 'Korean', 'HC', 'HC HDRip', 'CAM', 'TS', 'SCREENER', 'DVDSCR',
        'R5', 'LiNE', 'INSPiRAL', 'HeBSuB', 'TaMiToS', 'Www', 'Nako',
        'New', 'Line', 'juggs', 'YTS.AG', 'YTS', 'IMAX'
        // Add any other common tags you encounter
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $movieNames = [
            "2 Fast 2 Furious (2003) [1080p]" => "2 Fast 2 Furious",
            "10,000 Saints (2015) [1080p]" => "10000 Saints",
            "Ant-Man 2015 1080p HDRip x264 AAC-JYK" => "Ant Man",
            "A Walk Among The Tombstones (2014)(Blurred) 1080p (WEB-DL) NLSubs SAM TBS" => "A Walk Among The Tombstones",
            "22.Jump.Street.2014.1080p.WEB-DL.AAC2.0.H264-RARBG" => "22 Jump Street",
            "Black.Widow.2021.1080p.WEBRip.x264-RARBG" => "Black Widow",
            "The.Possession.2012.1080p.BRrip.x264.GAZ" => "The Possession",
            "TheKarateKid" => "The Karate Kid",
            "The Dark Knight Rises[2012]BRRip 720p H264-ETRG" => "The Dark Knight Rises",
            "Kingsman The Golden Circle (2017) [YTS.AG]" => "Kingsman The Golden Circle",
            "Tenacious D in The Pick of Destiny [2006-DVDRip-H.264]-NewArtRiot" => "Tenacious D in The Pick of Destiny",
            "Transformers Revenge of the Fallen IMAX EDITION (2009)" => "Transformers Revenge of the Fallen",
            "VHS Viral (2014) [1080p]" => "VHS Viral",
        ];

        foreach ($movieNames as $key => $value) {
            $cleanName = $this->cleanMovieName($key);
            if ($value != $cleanName) {
                $this->info(sprintf("Movie name %s is not correct, got %s instead of %s", $key, $cleanName, $value));
            }
        }
    }

    protected function cleanMovieName($name)
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


}
