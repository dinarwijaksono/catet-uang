<?php

namespace App\RepositoryInterface;

use App\Models\ApiToken;
use Carbon\Carbon;

interface ApiTokenRepositoryInterface
{
    public function create(int $userId, string $token, Carbon $expiredAt): ?ApiToken;
}
