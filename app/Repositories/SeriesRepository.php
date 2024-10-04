<?php
// app/Repositories/SeriesRepository.php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use NetflixEngine\Series\SeriesRepositoryInterface;
use NetflixEngine\Series\Exceptions\SeriesNotFoundException;
use NetflixEngine\Series\SeriesData;
use App\Models\Series as SeriesModel;

class SeriesRepository implements SeriesRepositoryInterface
{
    public function findById(int $id): SeriesData
    {
        $model = SeriesModel::find($id);

        if (!$model) {
            throw new SeriesNotFoundException("Series with ID {$id} not found.");
        }

        return $this->mapToEntity($model);
    }

    public function add(array $data): SeriesData
    {
        $model = SeriesModel::create($data);

        return $this->mapToEntity($model);
    }

    public function update(int $id, array $data): void
    {
        $model = SeriesModel::find($id);

        if (!$model) {
            throw new SeriesNotFoundException("Series with ID {$id} not found.");
        }

        $model->update($data);
    }

    public function delete(int $id): void
    {
        $model = SeriesModel::find($id);

        if (!$model) {
            throw new SeriesNotFoundException("Series with ID {$id} not found.");
        }

        $model->delete();
    }

    public function all(): array
    {
        $models = SeriesModel::all();

        return $models->map(fn($model) => $this->mapToEntity($model))->toArray();
    }

    private function mapToEntity(SeriesModel $model): SeriesData
    {
        return new SeriesData(
            $model->id,
            $model->name,
            $model->description,
            $model->path,
            $model->photo,
            $model->season,
            $model->episode,
            $model->progress_time,
            $model->category_id
        );
    }

    public function latest(int $limit): array
    {
        $models = SeriesModel::orderBy('created_at', 'desc')->limit($limit)->get();

        return $models->map(fn($model) => $this->mapToEntity($model))->toArray();
    }

    public function paginate(int $perPage): LengthAwarePaginator
    {
        return SeriesModel::orderBy('created_at', 'desc')->paginate($perPage);
    }
}
