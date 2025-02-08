<?php

namespace App\RepositoryInterface;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function create(int $userId, string $code, string $name, string $type): ?Category;
}
