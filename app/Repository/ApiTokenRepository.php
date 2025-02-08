<?php

namespace App\Repository;

use App\Models\ApiToken;
use App\RepositoryInterface\ApiTokenRepositoryInterface;
use Carbon\Carbon;

class ApiTokenRepository implements ApiTokenRepositoryInterface
{
    public function create(int $userId, string $token, Carbon $expiredAt): ?ApiToken
    {
        return ApiToken::create([
            'user_id' => $userId,
            'token' => $token,
            'expired_at' => $expiredAt
        ]);
    }
}
