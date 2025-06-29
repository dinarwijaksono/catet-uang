<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Service\ApiTokenService;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthControllerApi extends Controller
{
    protected $userService;
    protected $apiTokenService;

    public function __construct(UserService $userService, ApiTokenService $apiTokenService)
    {
        $this->userService = $userService;
        $this->apiTokenService = $apiTokenService;
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), (new RegisterRequest())->rules());

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            $validateEmail = Validator::make($request->all(), [
                'email' => 'unique:users,email'
            ]);
            if ($validateEmail->fails()) {
                return response()->json([
                    'errors' => [
                        'email' => ['Email tidak tersedia.']
                    ]
                ], 422);
            }

            DB::beginTransaction();
            $user = $this->userService->register($request->name, $request->email, $request->password);
            $token = $this->apiTokenService->create($user->id);

            Log::info('register success', [
                'user_id' => $user->id,
                'token' => $token->token
            ]);

            DB::commit();

            return response()->json([
                'data' => [
                    'api_token' => $token->token,
                    'expired_token' => $token->expired_at,
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('register failed', [
                'message' => $th->getMessage()
            ]);
        }
    }
}
