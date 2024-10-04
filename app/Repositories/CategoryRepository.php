<?php
// app/Repositories/CategoryRepository.php

namespace App\Repositories;

use NetflixEngine\Category\CategoryRepositoryInterface;
use NetflixEngine\Category\Exceptions\CategoryNotFoundException;
use NetflixEngine\Category\CategoryData;
use App\Models\Category as CategoryModel;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function findById(int $id): CategoryData
    {
        $model = CategoryModel::find($id);

        if (!$model) {
            throw new CategoryNotFoundException("Category with ID {$id} not found.");
        }

        return $this->mapToEntity($model);
    }

    public function add(array $data): CategoryData
    {
        $model = CategoryModel::create($data);

        return $this->mapToEntity($model);
    }

    public function update(int $id, array $data): void
    {
        $model = CategoryModel::find($id);

        if (!$model) {
            throw new CategoryNotFoundException("Category with ID {$id} not found.");
        }

        $model->update($data);
    }

    public function delete(int $id): void
    {
        $model = CategoryModel::find($id);

        if (!$model) {
            throw new CategoryNotFoundException("Category with ID {$id} not found.");
        }

        $model->delete();
    }

    public function all(): array
    {
        $models = CategoryModel::all();

        return $models->map(fn($model) => $this->mapToEntity($model))->toArray();
    }

    private function mapToEntity(CategoryModel $model): CategoryData
    {
        return new CategoryData(
            $model->id,
            $model->name
        );
    }
}
