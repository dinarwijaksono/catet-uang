<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
}
