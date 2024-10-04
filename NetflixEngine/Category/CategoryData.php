<?php
// NetflixEngine/Category/CategoryData.php

namespace NetflixEngine\Category;

final class CategoryData
{
    public int $id;
    public string $name;

    public function __construct(
        int $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }
}
