<?php
// NetflixEngine/Series/SeriesData.php

namespace NetflixEngine\Series;

final class SeriesData
{
    public int $id;
    public string $name;
    public string $description;
    public string $path;
    public string $photo;
    public int $season;
    public int $episode;
    public int $progress_time;
    public int $category_id;

    public function __construct(
        int $id,
        string $name,
        string $description,
        string $path,
        string $photo,
        int $season,
        int $episode,
        int $progress_time,
        int $category_id
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->path = $path;
        $this->photo = $photo;
        $this->season = $season;
        $this->episode = $episode;
        $this->progress_time = $progress_time;
        $this->category_id = $category_id;
    }
}
