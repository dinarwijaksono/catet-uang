<?php

namespace App\Repository;

use App\Models\Category;
use App\RepositoryInterface\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

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

    public function getAll(int $userId): Collection
    {
        return Category::where('user_id', $userId)
            ->get();
    }
}
