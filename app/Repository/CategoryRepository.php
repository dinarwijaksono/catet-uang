<?php

namespace App\Repository;

use App\Models\Category;
use App\RepositoryInterface\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function create(int $userId, string $code, string $name, string $type): ?Category
    {
        return Category::create([
            'user_id' => $userId,
            'code' => $code,
            'name' => strtolower($name),
            'type' => strtolower($type)
        ]);
    }
}
