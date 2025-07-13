<?php

namespace App\RepositoryInterface;

use App\Models\ApiToken;
use Carbon\Carbon;
use stdClass;

interface ApiTokenRepositoryInterface
{
    public function create(int $userId, string $token, Carbon $expiredAt): ?ApiToken;

    public function findById(int $userId): ?stdClass;

    public function findByToken(string $token): ?stdClass;

    public function delete(string $token): void;
}
