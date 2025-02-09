<?php

namespace App\Service;

use App\Models\Category;
use App\RepositoryInterface\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CategoryService
{
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function create(int $userId, string $name, string $type): ?Category
    {
        try {

            $code = Str::random(10);
            $category = $this->categoryRepository->create($userId, $code, $name, $type);

            Log::info('create category success', [
                'user_id' => $userId,
                'category_code' => $code,
                'category_name' => $name,
                'category_type' => $type
            ]);

            return $category;
        } catch (\Throwable $th) {
            Log::error('create category error', [
                'user_id' => $userId,
                'category_code' => $code,
                'category_name' => $name,
                'category_type' => $type,
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }

    public function getAll(int $userId): Collection
    {
        try {
            Log::info('get all category success', [
                'user_id' => $userId
            ]);

            return $this->categoryRepository->getAll($userId);
        } catch (\Throwable $th) {
            Log::error('get all category failed', [
                'user_id' => $userId,
                'message' => $th->getMessage()
            ]);

            return collect();
        }
    }
}
