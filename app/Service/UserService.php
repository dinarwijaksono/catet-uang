<?php

namespace App\Service;

use App\RepositoryInterface\ApiTokenRepositoryInterface;
use App\RepositoryInterface\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use stdClass;

class UserService
{
    protected UserRepositoryInterface $userRepository;
    protected ApiTokenRepositoryInterface $apiTokenRepository;

    public function __construct(UserRepositoryInterface $userRepository, ApiTokenRepositoryInterface $apiTokenRepository)
    {
        $this->userRepository = $userRepository;
        $this->apiTokenRepository = $apiTokenRepository;
    }

    public function registerForApi(string $name, string $email, string $password): ?stdClass
    {
        try {
            DB::beginTransaction();

            $user = $this->userRepository->create($name, $email, $password);

            $token = Str::random(32);
            $expiredAt = Carbon::now()->addDays(3);
            $apiToken = $this->apiTokenRepository->create($user->id, $token, $expiredAt);

            DB::commit();

            Log::info('register berhasil', [
                'user_id' => $apiToken->user_id,
                'email' => $apiToken->email,
                'token' => $apiToken->token
            ]);

            return $apiToken;
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('register gagal', [
                'user_id' => $apiToken->user_id,
                'email' => $apiToken->email,
                'token' => $apiToken->token,
                'message' => $e->getMessage()
            ]);

            return null;
        }
    }
}
