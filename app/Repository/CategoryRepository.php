<?php

namespace App\Repository;

use App\Models\Category;
use App\RepositoryInterface\CategoryRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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

    public function checkIsStillUse(int $userId, int $categoryId): bool
    {
        $transaction = DB::table('transactions')
            ->where('user_id', $userId)
            ->where('category_id', $categoryId)
            ->get();

        return !$transaction->isEmpty();
    }

    public function findByCode(int $userId, string $code): ?Category
    {
        return Category::select(
            'id',
            'code',
            'name',
            'type',
            'created_at',
            'updated_at'
        )
            ->where('user_id', $userId)
            ->where('code', $code)
            ->first();
    }

    public function findByName(int $userId, string $name, string $type): ?Category
    {
        return Category::select(
            'id',
            'code',
            'name',
            'type',
            'created_at',
            'updated_at'
        )
            ->where('user_id', $userId)
            ->where('name', $name)
            ->where('type', $type)
            ->first();
    }

    public function getAll(int $userId): Collection
    {
        return Category::select(
            'id',
            'code',
            'name',
            'type',
            'created_at',
            'updated_at'
        )
            ->where('user_id', $userId)
            ->get();
    }

    public function update(int $userId, string $code, string $name): ?Category
    {
        Category::where('code', $code)
            ->where('user_id', $userId)
            ->update([
                'name' => $name,
                'updated_at' => Carbon::now()
            ]);

        return Category::where('code', $code)->first();
    }

    public function delete(int $userId, string $code): void
    {
        Category::where('user_id', $userId)
            ->where('code', $code)
            ->delete();
    }
}
