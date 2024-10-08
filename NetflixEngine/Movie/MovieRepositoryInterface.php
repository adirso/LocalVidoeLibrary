<?php
// NetflixEngine/Movie/MovieRepositoryInterface.php

namespace NetflixEngine\Movie;

use Illuminate\Pagination\LengthAwarePaginator;
use NetflixEngine\Movie\Exceptions\MovieNotFoundException;

interface MovieRepositoryInterface
{
    /**
     * Find a movie by its ID.
     *
     * @param int $id
     * @return MovieData
     * @throws MovieNotFoundException
     */
    public function findById(int $id): MovieData;

    /**
     * Add a new movie.
     *
     * @param array $data
     * @return MovieData
     */
    public function add(array $data): MovieData;

    /**
     * Update an existing movie.
     *
     * @param int $id
     * @param array $data
     * @throws MovieNotFoundException
     */
    public function update(int $id, array $data): void;

    /**
     * Delete a movie by its ID.
     *
     * @param int $id
     * @throws MovieNotFoundException
     */
    public function delete(int $id): void;

    /**
     * Get all movies.
     *
     * @return MovieData[]
     */
    public function all(): array;

    public function latest(int $limit): array;

    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage): LengthAwarePaginator;

    /**
     * @param int $limit
     * @return array
     */
    public function getLastViewedMovies(int $limit): array;
}
