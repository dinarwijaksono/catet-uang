<?php

namespace App\Service;

use App\RepositoryInterface\ApiTokenRepositoryInterface;
use App\RepositoryInterface\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

    public function loginForApi(string $email, string $passowrd): ?stdClass
    {
        try {
            $user = $this->userRepository->findByEmail($email);

            if (!Hash::check($passowrd, $user->password)) {
                Log::error('login for api failed', [
                    'email' => $email,
                    'message' => 'Password salah'
                ]);

                return null;
            }

            $token = Str::random(32);
            $this->apiTokenRepository->create($user->id, $token, Carbon::now()->addDays(3));

            $apiToken = $this->apiTokenRepository->findByToken($token);

            Log::info('login success', [
                'email' => $email
            ]);

            return $apiToken;
        } catch (\Throwable $th) {
            Log::error('login gagal', [
                'email' => $email,
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }

    public function findByToken(string $token): ?stdClass
    {
        try {
            $user = $this->apiTokenRepository->findByToken($token);

            Log::info('find by token success', [
                'token' => $token,
                'email' => $user->email
            ]);

            return $user;
        } catch (\Throwable $th) {
            Log::info('find by token failed', [
                'token' => $token,
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }
}
