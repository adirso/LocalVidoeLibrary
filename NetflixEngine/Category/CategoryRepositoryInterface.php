<?php
// NetflixEngine/Category/CategoryRepositoryInterface.php

namespace NetflixEngine\Category;

use NetflixEngine\Category\Exceptions\CategoryNotFoundException;

interface CategoryRepositoryInterface
{
    public function findById(int $id): CategoryData;

    public function add(array $data): CategoryData;

    public function update(int $id, array $data): void;

    public function delete(int $id): void;

    public function all(): array;
}
