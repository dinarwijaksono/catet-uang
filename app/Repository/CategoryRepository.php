<?php

namespace App\Repository;

use App\Models\Category;

class CategoryRepository
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
