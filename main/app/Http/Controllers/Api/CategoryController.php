<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\CreateCategoryRequest;
use App\Service\CategoryService;
use App\Service\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    protected UserService $userService;
    protected CategoryService $categoryService;

    public function __construct(UserService $userService, CategoryService $categoryService)
    {
        $this->userService = $userService;
        $this->categoryService = $categoryService;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), (new CreateCategoryRequest())->rules());

        $user = $this->userService->findByToken($request->header('api-token'));

        if ($validator->fails()) {
            Log::warning('Crete category failed', [
                'user_email' => $user->email,
                'category_name' => $request->name,
                'category_type' => $request->type,
                'message' => "Validasi error"
            ]);

            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->categoryService->create($user->user_id, $request->name, $request->type);

        Log::info('create category success', [
            'user_email' => $user->email,
            'category_name' => $request->name,
            'category_type' => $request->type
        ]);

        return response()->json([
            'data' => [
                'code' => $result->code,
                'name' => $result->name,
                'type' => $result->type,
            ]
        ], 201);
    }

    public function getAll(Request $request): JsonResponse
    {
        $token = $this->userService->findByToken($request->header('api-token'));

        $categories = $this->categoryService->getAll($token->user_id);

        return response()->json([
            'data' => $categories->toArray(),
            'category_count' => $categories->count()
        ], 200);
    }

    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), (new CategoryUpdateRequest())->rules());

        $apiToken = $this->userService->findByToken($request->header('api-token'));

        if ($validator->fails()) {
            Log::warning('update category failed', [
                'user_id' => $apiToken->user_id,
                'message' => 'validasi error'
            ]);

            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $category = $this->categoryService->update($apiToken->user_id, $request->code, $request->name);

        return response()->json([
            'data' => [
                'code' => $category->code,
                'name' => $category->name,
                'type' => $category->type
            ]
        ], 200);
    }

    public function delete(Request $request): ?JsonResponse
    {
        $token = $this->userService->findByToken($request->header('api-token'));

        $validator = Validator::make($request->all(), [
            'code' => 'required'
        ]);

        if ($validator->fails()) {
            Log::warning("DELETE /api/category failed", [
                'user_id' => $token->user_id,
                'message' => 'Validate error'
            ]);

            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $this->categoryService->delete($token->user_id, $request->code);

        Log::info("DELETE /api/category success", [
            'user_id' => $token->user_id,
            'data' => [
                'category_code' => $request->code,
            ]
        ]);

        return response()->json([
            'message' => ["Kategori berhasil di hapus"]
        ], 200);
    }
}
