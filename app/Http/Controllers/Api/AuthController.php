<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), (new RegisterRequest())->rules());

        if ($validator->fails()) {
            Log::warning('/api/register fails - validate error', [
                'email' => $request->email,
                'errors' => $validator->errors()
            ]);

            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $validatorEmail = Validator::make($request->all(), [
            'email' => 'unique:users,email'
        ]);

        if ($validatorEmail->fails()) {
            Log::warning('/api/register fails - email duplicate', [
                'email' => $request->email
            ]);

            return response()->json([
                'errors' => [
                    'general' => 'Email tidak tersedia.'
                ]
            ], 400);
        }

        $register = $this->userService->registerForApi($request->name, $request->email, $request->password);

        return response()->json([
            'data' => [
                'api_token' => $register->token,
                'expired_token' => $register->expired_at,
                'name' => $register->name,
                'email' => $register->email
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), (new LoginRequest())->rules());

        if ($validator->fails()) {
            Log::warning('login failed', [
                'email' => $request->email,
                'message' => "validad error",
                'errors' => $validator->errors()
            ]);

            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->userService->loginForApi($request->email, $request->password);

        if (!$result) {
            Log::warning('login failed', [
                'email' => $request->email,
                'message' => "validad password error",
                'errors' => $validator->errors()
            ]);

            return response()->json([
                'errors' => [
                    'general' => 'Email atau password salah.'
                ]
            ], 400);
        }

        Log::info('Login success', ['email' => $request->email]);

        return response()->json([
            'data' => [
                'api_token' => $result->token,
                'expired_token' => $result->expired_at,
                'name' => $result->name,
                'email' => $result->email
            ]
        ], 200);
    }
}
