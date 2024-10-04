<?php
// app/Repositories/MovieRepository.php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use NetflixEngine\Movie\MovieRepositoryInterface;
use NetflixEngine\Movie\Exceptions\MovieNotFoundException;
use NetflixEngine\Movie\MovieData;
use App\Models\Movie as MovieModel;

class MovieRepository implements MovieRepositoryInterface
{
    public function findById(int $id): MovieData
    {
        $model = MovieModel::find($id);

        if (!$model) {
            throw new MovieNotFoundException("Movie with ID {$id} not found.");
        }

        return $this->mapToEntity($model);
    }

    public function add(array $data): MovieData
    {
        $model = MovieModel::create($data);

        return $this->mapToEntity($model);
    }

    public function update(int $id, array $data): void
    {
        $model = MovieModel::find($id);

        if (!$model) {
            throw new MovieNotFoundException("Movie with ID {$id} not found.");
        }

        $model->update($data);
    }

    public function delete(int $id): void
    {
        $model = MovieModel::find($id);

        if (!$model) {
            throw new MovieNotFoundException("Movie with ID {$id} not found.");
        }

        $model->delete();
    }

    public function all(): array
    {
        $models = MovieModel::all();

        return $models->map(fn($model) => $this->mapToEntity($model))->toArray();
    }

    private function mapToEntity(MovieModel $model): MovieData
    {
        return new MovieData(
            $model->id,
            $model->name,
            $model->description,
            $model->path,
            $model->photo,
            $model->progress_time,
            $model->category_id
        );
    }

    public function latest(int $limit): array
    {
        $models = MovieModel::orderBy('created_at', 'desc')->limit($limit)->get();

        return $models->map(fn($model) => $this->mapToEntity($model))->toArray();
    }

    public function paginate(int $perPage): LengthAwarePaginator
    {
        return MovieModel::orderBy('created_at', 'desc')->paginate($perPage);
    }

}
