<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Service\CategoryService;
use App\Service\UserService;
use Illuminate\Http\JsonResponse;

class CategoryControllerApi extends Controller
{
    protected $userService;
    protected $categoryService;

    public function __construct(UserService $userService, CategoryService $categoryService)
    {
        $this->userService = $userService;
        $this->categoryService = $categoryService;
    }

    public function create(CreateCategoryRequest $request): ?JsonResponse
    {
        $token = $request->header('api-token');
        $user = $this->userService->findByToken($token);

        $category = $this->categoryService->create($user->user_id, $request->name, $request->type);

        return response()->json([
            'data' => [
                'code' => $category->code,
                'name' => $category->name,
                'type' => $category->type,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at
            ]
        ], 201);
    }

    public function getAll(Request $request)
    {
        $token = $request->header('api-token');
        $user = $this->userService->findByToken($token);

        $category = $this->categoryService->getAll($user->user_id);

        return response()->json([
            'data' => CategoryResource::collection($category->sortBy('name')),
            'category_count' => $category->count()
        ], 200);
    }

    public function getCategory(Request $request): ?JsonResponse
    {
        $token = $request->header('api-token');
        $user = $this->userService->findByToken($token);

        $category = $this->categoryService->findByCode($user->user_id, $request->code);

        if (!$category) {
            return response()->json([
                'message' => 'Kategori tidak ditemukan.'
            ], 400);
        }

        return response()->json([
            'data' => new CategoryResource($category)
        ], 200);
    }

    public function delete(Request $request)
    {
        $token = $request->header('api-token');
        $user = $this->userService->findByToken($token);

        $category = $this->categoryService->findByCode($user->user_id, $request->code);

        if (!$category) {
            return response()->json([
                'message' => 'Kategori tidak ditemukan.'
            ], 400);
        }

        if ($this->categoryService->checkIsStillUse($user->user_id, $category->id)) {
            return response()->json([
                'message' => 'Tidak bisa menghapus kategori yang masih digunakan.'
            ], 400);
        }

        $this->categoryService->delete($user->user_id, $request->code);

        return response()->json([], 204);
    }
}
