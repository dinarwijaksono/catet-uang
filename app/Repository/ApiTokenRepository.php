<?php

namespace App\Repository;

use App\Models\ApiToken;
use App\RepositoryInterface\ApiTokenRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use stdClass;

class ApiTokenRepository implements ApiTokenRepositoryInterface
{
    public function create(int $userId, string $token, Carbon $expiredAt): ?stdClass
    {
        $apiToken = ApiToken::create([
            'user_id' => $userId,
            'token' => $token,
            'expired_at' => $expiredAt
        ]);

        return DB::table('api_tokens')
            ->join('users', 'users.id', '=', 'api_tokens.user_id')
            ->select(
                'api_tokens.token',
                'api_tokens.expired_at',
                'users.id as user_id',
                'users.name',
                'users.email',
                'users.created_at',
                'users.updated_at'
            )
            ->where('users.id', $apiToken->user_id)
            ->first();
    }

    public function findById(int $userId): ?stdClass
    {
        return DB::table('api_tokens')
            ->join('users', 'users.id', '=', 'api_tokens.user_id')
            ->select(
                'api_tokens.token',
                'api_tokens.expired_at',
                'users.id as user_id',
                'users.name',
                'users.email',
                'users.created_at',
                'users.updated_at'
            )
            ->where('users.id', $userId)
            ->first();
    }

    public function findByToken(string $token): ?stdClass
    {
        return DB::table('api_tokens')
            ->join('users', 'users.id', '=', 'api_tokens.user_id')
            ->select(
                'api_tokens.token',
                'api_tokens.expired_at',
                'users.id as user_id',
                'users.name',
                'users.email',
                'users.created_at',
                'users.updated_at'
            )
            ->where('api_tokens.token', $token)
            ->first();
    }
}
