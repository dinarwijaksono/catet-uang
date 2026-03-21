<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PeriodResource;
use App\Service\PeriodService;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PeriodControllerApi extends Controller
{
    protected $userService;
    protected $periodService;

    public function __construct(UserService $userService, PeriodService $periodService)
    {
        $this->userService = $userService;
        $this->periodService = $periodService;
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
