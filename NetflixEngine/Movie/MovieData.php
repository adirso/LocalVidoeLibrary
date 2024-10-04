<?php
// NetflixEngine/Movie/MovieData.php

namespace NetflixEngine\Movie;

final class MovieData
{
    public int $id;
    public string $name;
    public string $description;
    public string $path;
    public string $photo;
    public int $progress_time;
    public int $category_id;

    public function __construct(
        int $id,
        string $name,
        string $description,
        string $path,
        string $photo,
        int $progress_time,
        int $category_id
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->path = $path;
        $this->photo = $photo;
        $this->progress_time = $progress_time;
        $this->category_id = $category_id;
    }
}
