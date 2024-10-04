<?php
// NetflixEngine/Category/CategoryService.php

namespace NetflixEngine\Category;

use NetflixEngine\Category\CategoryRepositoryInterface;
use NetflixEngine\Category\CategoryData;

class CategoryService
{
    private CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getCategoryById(int $id): CategoryData
    {
        return $this->repository->findById($id);
    }

    public function createCategory(array $data): CategoryData
    {
        return $this->repository->add($data);
    }

    public function updateCategory(int $id, array $data): void
    {
        $this->repository->update($id, $data);
    }

    public function deleteCategory(int $id): void
    {
        $this->repository->delete($id);
    }

    public function listCategories(): array
    {
        return $this->repository->all();
    }
}
