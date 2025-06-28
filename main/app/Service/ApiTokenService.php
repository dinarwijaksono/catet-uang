<?php

namespace App\Service;

use App\Models\ApiToken;
use App\Repository\ApiTokenRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ApiTokenService
{
    protected $apiTokenRepository;

    public function __construct(ApiTokenRepository $apiTokenRepository)
    {
        $this->apiTokenRepository = $apiTokenRepository;
    }

    public function create(int $userId): ?ApiToken
    {
        try {

            $token = \Illuminate\Support\Str::random(32);
            $expiredAt = Carbon::now()->addDays(3);

            $apiToken = $this->apiTokenRepository->create($userId, $token, $expiredAt);

            Log::info('create token success', [
                'user_id' => $userId,
                'token' => $token
            ]);

            return $apiToken;
        } catch (\Throwable $th) {
            Log::info('create token failed', [
                'user_id' => $userId,
                'message' => $th->getMessage()
            ]);
        }
    }
}
