<?php
// NetflixEngine/Series/SeriesService.php

namespace NetflixEngine\Series;

use NetflixEngine\Series\SeriesRepositoryInterface;
use NetflixEngine\Series\SeriesData;

class SeriesService
{
    private SeriesRepositoryInterface $repository;

    public function __construct(SeriesRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getSeriesById(int $id): SeriesData
    {
        return $this->repository->findById($id);
    }

    public function createSeries(array $data): SeriesData
    {
        return $this->repository->add($data);
    }

    public function updateSeries(int $id, array $data): void
    {
        $this->repository->update($id, $data);
    }

    public function deleteSeries(int $id): void
    {
        $this->repository->delete($id);
    }

    public function listSeries(): array
    {
        return $this->repository->all();
    }

    public function getLatestSeries(int $limit): array
    {
        return $this->repository->latest($limit);
    }
}
