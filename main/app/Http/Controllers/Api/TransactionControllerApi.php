<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionRequest;
use App\Service\TransactionService;
use App\Service\UserService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        if ($request->value <= 0) {
            return response()->json([
                'errors' => [
                    'value' => ['Value tidak boleh bernilai 0 atau lebih kecil.']
                ]
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

    public function getByDate(Request $request): ?JsonResponse
    {
        try {
            $token = $request->header('api-token');
            $user = $this->userService->findByToken($token);

            $date = Carbon::createFromFormat('Y-m-d', $request->date)->setTime(0, 0, 0, 0);

            $transaction = $this->transactionService->getByDate($user->user_id, $date);

            return response()->json([
                'data' => $transaction,
                'transaction_count' => $transaction->count()
            ], 200);
        } catch (\Throwable $th) {

            Log::error('get by date error', [
                'date' => $request->date,
                'message' => $th->getMessage()
            ]);

            return response()->json([
                'message' => 'Permintaan tidak valid.'
            ], 400);
        }
    }

    public function updateTransaction(Request $request): ?JsonResponse
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

        $transaction = $this->transactionService->update(
            $user->user_id,
            $request->code,
            $request->category,
            $request->date,
            $request->description,
            $income,
            $spending
        );

        return response()->json([
            'data' => $transaction
        ], 200);
    }

    public function delete(Request $request): ?JsonResponse
    {
        $token = $request->header('api-token');
        $user = $this->userService->findByToken($token);

        $this->transactionService->delete($user->user_id, $request->code);

        return response()->json([], 204);
    }
}
