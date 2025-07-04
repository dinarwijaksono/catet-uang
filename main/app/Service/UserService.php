<?php

namespace App\Service;

use App\Models\User;
use App\RepositoryInterface\ApiTokenRepositoryInterface;
use App\RepositoryInterface\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
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

    public function register(string $name, string $email, string $password): ?User
    {
        try {

            $start = microtime(true);
            $findByEmail = $this->userRepository->findByEmail($email);
            if (!is_null($findByEmail)) {
                Log::alert('register failed', [
                    'message' => 'duplicate email'
                ]);

                return null;
            }
            $executionTime = round((microtime(true) - $start) * 1000);
            if ($executionTime > 2000) {
                Log::warning("Execution of UserRepository->findByEmail is slow", [
                    'execution_time' => $executionTime
                ]);
            }

            $start = microtime(true);
            $user = $this->userRepository->create($name, $email, $password);
            $executionTime = round((microtime(true) - $start) * 1000);
            if ($executionTime > 2000) {
                Log::warning("Execution of UserRepository->create is slow", [
                    'user_id' => $user->id,
                    'execution_time' => $executionTime
                ]);
            }

            if ($user) {
                Auth::login($user, true);
            }

            Log::info('register success', [
                'user_id' => $user->id,
            ]);

            return $user;
        } catch (\Throwable $th) {
            Log::error('register failed', [
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }

    public function login(string $email, string $passowrd): ?User
    {
        try {
            $user = $this->userRepository->findByEmail($email);

            if (!$user) {
                Log::warning('login failed, email is wrong', [
                    'user_email' => $email,
                    'message' => 'email is wrong'
                ]);

                return null;
            }

            if (!Hash::check($passowrd, $user->password)) {
                Log::warning('login failed, password is wrong', [
                    'user_email' => $email,
                    'message' => 'password is wrong'
                ]);

                return null;
            }

            Log::info('login success', [
                'user_email' => $email,
            ]);

            return $user;
        } catch (\Throwable $th) {
            Log::warning('login failed.', [
                'user_email' => $email,
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
            Log::error('find by token failed', [
                'token' => $token,
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }

    public function findByEmail(string $email): ?User
    {
        try {
            $user = $this->userRepository->findByEmail($email);

            Log::info('find user by email success', [
                'id' => $user->id
            ]);

            return $user;
        } catch (\Throwable $th) {
            Log::error('find user by email failed', [
                'email' => $email,
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }

    public function logout(string $token)
    {
        try {
            Log::info('logout success', [
                'token' => $token
            ]);

            $this->apiTokenRepository->delete($token);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
