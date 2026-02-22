<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportTotalIncomeSpendingResource;
use App\Service\ReportService;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportControllerApi extends Controller
{
    protected UserService $userService;
    protected ReportService $reportService;

    public function __construct(
        UserService $userService,
        ReportService $reportService
    ) {
        $this->userService = $userService;
        $this->reportService = $reportService;
    }

    public function getTotalIncomeSpending(Request $request)
    {
        try {
            $user = $this->userService->findByToken($request->header('api-token'));

            $data = $this->reportService->getTotalIncomeSpending($user->user_id);

            Log::info('get total income spending success', [
                'token' => $request->header('api-token'),
            ]);

            return response()->json([
                'data' => new ReportTotalIncomeSpendingResource($data)
            ], 200);
        } catch (\Exception $th) {
            Log::error('get total income spending failed', [
                'token' => $request->header('api-token'),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'message' => $th->getMessage()
            ]);

            return response()->json([
                'message' => $th->getMessage()
            ], 400);
        }
    }
}
