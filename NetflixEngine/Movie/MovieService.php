<?php
// NetflixEngine/Movie/MovieService.php

namespace NetflixEngine\Movie;

use NetflixEngine\Movie\MovieRepositoryInterface;
use NetflixEngine\Movie\MovieData;

class MovieService
{
    private MovieRepositoryInterface $repository;

    public function __construct(MovieRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get a movie by ID.
     *
     * @param int $id
     * @return MovieData
     */
    public function getMovieById(int $id): MovieData
    {
        return $this->repository->findById($id);
    }

    /**
     * Create a new movie.
     *
     * @param array $data
     * @return MovieData
     */
    public function createMovie(array $data): MovieData
    {
        return $this->repository->add($data);
    }

    /**
     * Update an existing movie.
     *
     * @param int $id
     * @param array $data
     */
    public function updateMovie(int $id, array $data): void
    {
        $this->repository->update($id, $data);
    }

    /**
     * Delete a movie.
     *
     * @param int $id
     */
    public function deleteMovie(int $id): void
    {
        $this->repository->delete($id);
    }

    /**
     * Get all movies.
     *
     * @return MovieData[]
     */
    public function listMovies(): array
    {
        return $this->repository->all();
    }

    public function getLatestMovies(int $limit): array
    {
        return $this->repository->latest($limit);
    }

    /**
     * @param int $limit
     * @return array
     */
    public function getLastViewedMovies(int $limit = 4): array
    {
        return $this->repository->getLastViewedMovies($limit);
    }
}
