<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionRequest;
use App\Service\TransactionService;
use App\Service\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionControllerApi extends Controller
{
    public $userService;
    public $transactionService;

    public function __construct(UserService $userService, TransactionService $transactionService)
    {
        $this->userService = $userService;
        $this->transactionService = $transactionService;
    }

    public function create(Request $request): ?JsonResponse
    {
        $validator = Validator::make($request->all(), (new CreateTransactionRequest())->rules());

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $token = $request->header('api-token');
        $user = $this->userService->findByToken($token);

        $income = $request->type == 'income' ? $request->value : 0;
        $spending = $request->type == 'spending' ? $request->value : 0;

        $transaction = $this->transactionService->create(
            $user->user_id,
            $request->category,
            $request->date,
            $request->description,
            $income,
            $spending
        );

        return response()->json([
            'data' => $transaction
        ], 201);
    }
}
