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

            $start = microtime(true);

            $code = Str::random(10);
            $category = $this->categoryRepository->create($userId, $code, $name, $type);

            $executionTime = round((microtime(true) - $start) * 1000);

            if ($executionTime > 2000) {
                Log::warning("Execution of CategoryRepository->create is slow", [
                    'user_id' => $userId,
                    'execution_time' => $executionTime
                ]);
            }

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

    public function checkIsStillUse(int $userId, int $categoryId): bool
    {
        try {
            $result = $this->categoryRepository->checkIsStillUse($userId, $categoryId);

            Log::info('check is still use success', [
                'user_id' => $userId
            ]);

            return $result;
        } catch (\Throwable $th) {
            Log::error('check is still use failed', [
                'user_id' => $userId,
                'message' => $th->getMessage()
            ]);

            return false;
        }
    }

    public function findByCode(int $userId, string $code): ?Category
    {
        try {
            $start = microtime(true);
            $category = $this->categoryRepository->findByCode($userId, $code);

            $executionTime = round((microtime(true) - $start) * 1000);
            if ($executionTime > 2000) {
                Log::warning("Execution of CategoryRepository->findByCode is slow", [
                    'user_id' => $userId,
                    'execution_time' => $executionTime
                ]);
            }

            Log::info('find category by code success', [
                'user_id' => $userId
            ]);

            return $category;
        } catch (\Throwable $th) {
            Log::error('find category by code failed', [
                'user_id' => $userId,
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }

    public function getByType(int $userId, string $type): ?Collection
    {
        try {
            $category = Category::where('user_id', $userId)
                ->where('type', $type)
                ->get();

            Log::info('get category by type success', [
                'user_id' => $userId
            ]);

            return $category;
        } catch (\Throwable $th) {
            Log::error('get category by type failed', [
                'user_id' => $userId,
                'error' => $th->getMessage()
            ]);

            return null;
        }
    }

    public function getAll(int $userId): Collection
    {
        try {
            $start = microtime(true);

            $result = $this->categoryRepository->getAll($userId);

            $executionTime = round((microtime(true) - $start) * 1000);

            if ($executionTime > 2000) {
                Log::warning("Execution of CategoryRepository->getAll is slow", [
                    'user_id' => $userId,
                    'execution_time' => $executionTime
                ]);
            }

            Log::info('get all category success', [
                'user_id' => $userId
            ]);

            return $result;
        } catch (\Throwable $th) {
            Log::error('get all category failed', [
                'user_id' => $userId,
                'message' => $th->getMessage()
            ]);

            return collect();
        }
    }

    public function update(int $userId, string $code, string $name): ?Category
    {
        try {
            $result = $this->categoryRepository->update($userId, $code, $name);

            Log::info('update category success', [
                'user_id' => $userId
            ]);

            return $result;
        } catch (\Throwable $th) {
            Log::error('update category failed', [
                'user_id' => $userId,
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }

    public function delete(int $userId, string $code): void
    {
        try {
            $this->categoryRepository->delete($userId, $code);

            Log::info('delete category success', [
                'user_id' => $userId,
                'data' => [
                    'category_code' => $code
                ]
            ]);
        } catch (\Throwable $th) {
            Log::error('delete category failed', [
                'user_id' => $userId,
                'data' => [
                    'category_code' => $code
                ],
                'message' => $th->getMessage()
            ]);
        }
    }
}
