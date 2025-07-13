<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Service\CategoryService;
use App\Service\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryControllerApi extends Controller
{
    protected $userService;
    protected $categoryService;

    public function __construct(UserService $userService, CategoryService $categoryService)
    {
        $this->userService = $userService;
        $this->categoryService = $categoryService;
    }

    public function create(Request $request): ?JsonResponse
    {
        $token = $request->header('api-token');
        $user = $this->userService->findByToken($token);

        $validator = Validator::make($request->all(), (new CreateCategoryRequest())->rules());
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

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
            'data' => $category,
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
            'data' => $category
        ], 200);
    }
}
