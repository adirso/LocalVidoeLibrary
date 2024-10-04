<?php
// NetflixEngine/Series/SeriesRepositoryInterface.php

namespace NetflixEngine\Series;

use Illuminate\Pagination\LengthAwarePaginator;
use NetflixEngine\Series\Exceptions\SeriesNotFoundException;

interface SeriesRepositoryInterface
{
    public function findById(int $id): SeriesData;

    public function add(array $data): SeriesData;

    public function update(int $id, array $data): void;

    public function delete(int $id): void;

    public function all(): array;

    public function latest(int $limit): array;

    public function paginate(int $perPage): LengthAwarePaginator;


}
