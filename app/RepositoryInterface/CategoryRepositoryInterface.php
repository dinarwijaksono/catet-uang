<?php

namespace App\RepositoryInterface;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function create(int $userId, string $code, string $name, string $type): ?Category;

    public function checkIsStillUse(int $userId, int $categoryId): bool;

    public function findByCode(int $userId, string $code): ?Category;

    public function findByName(int $userId, string $name, string $type): ?Category;

    public function getAll(int $userId): Collection;

    public function update(int $userId, string $code, string $name): ?Category;

    public function delete(int $userId, string $code): void;
}
