<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PeriodResource;
use App\Models\Period;
use App\Service\PeriodService;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class PeriodControllerApi extends Controller
{
    protected $userService;
    protected $periodService;

    public function __construct(UserService $userService, PeriodService $periodService)
    {
        $this->userService = $userService;
        $this->periodService = $periodService;
    }

    public function getById(Request $request, int $id): JsonResponse
    {
        try {
            $user = $this->userService->findByToken($request->header('api-token'));

            Log::info('get period by id success', [
                'user_id' => $user->user_id
            ]);

            $period = Period::find($id);

            if (!$period) {
                Log::warning('get period by id is empty.', [
                    'user_id' => $user->user_id
                ]);

                return response()->json([
                    'errors' => [
                        'general' => 'Period tidak ditemukan.'
                    ]
                ], 400);
            }

            Log::info('get period by id success', [
                'user_id' => $user->user_id
            ]);

            return response()->json([
                'data' => new PeriodResource($period),
            ], 200);
        } catch (\Throwable $th) {
            Log::error('get period by id failed', [
                'message' => $th->getMessage(),
                'user_id' => $user->user_id
            ]);

            return response()->json([
                'errors' => ['generate' => ['Terdapat kesalahan.']]
            ], 400);
        }
    }

    public function getAll(Request $request)
    {
        try {
            $user = $this->userService->findByToken($request->header('api-token'));
            $period = $this->periodService->getAll($user->user_id);

            Log::info('get all periode success', [
                'api-token' => $request->header('api-token')
            ]);

            return response()->json([
                'data' => PeriodResource::collection($period),
                'period_count' => $period->count()
            ], 200);
        } catch (\Throwable $th) {
            Log::error('get all periode failed', [
                'api-token' => $request->header('api-token'),
                'message' => $th->getMessage()
            ]);

            return response()->json([
                'message' => 'ada kesalahan.'
            ], 400);
        }
    }
}
