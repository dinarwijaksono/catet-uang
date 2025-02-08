<?php

namespace App\RepositoryInterface;

use Carbon\Carbon;
use stdClass;

interface ApiTokenRepositoryInterface
{
    public function create(int $userId, string $token, Carbon $expiredAt): ?stdClass;

    public function findById(int $userId): ?stdClass;

    public function findByToken(string $token): ?stdClass;
}
