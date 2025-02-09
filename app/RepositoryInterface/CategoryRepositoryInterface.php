<?php

namespace App\RepositoryInterface;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function create(int $userId, string $code, string $name, string $type): ?Category;

    public function getAll(int $userId): Collection;
}
