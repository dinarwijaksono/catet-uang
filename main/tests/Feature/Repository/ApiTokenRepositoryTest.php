<?php

namespace Tests\Feature\Repository;

use App\Models\ApiToken;
use App\Models\User;
use App\RepositoryInterface\ApiTokenRepositoryInterface;
use App\RepositoryInterface\UserRepositoryInterface;
use Carbon\Carbon;
use Database\Seeders\CreateUserWithTokenSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use stdClass;
use Tests\TestCase;

class ApiTokenRepositoryTest extends TestCase
{
    protected $userRepository;
    protected $apiTokenRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->app->make(UserRepositoryInterface::class);
        $this->apiTokenRepository = $this->app->make(ApiTokenRepositoryInterface::class);
    }

    public function test_create_success(): void
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('rahasia')
        ]);

        $token = Str::random(32);
        $expiredAt = Carbon::now()->addDays(3);

        $response = $this->apiTokenRepository->create($user->id, $token, $expiredAt);

        $this->assertDatabaseHas('api_tokens', [
            'user_id' => $user->id,
            'token' => $token,
            'expired_at' => $expiredAt
        ]);

        $this->assertInstanceOf(ApiToken::class, $response);
        $this->assertEquals($response->user_id, $user->id);
        $this->assertEquals($response->token, $token);
        $this->assertEquals($response->expired_at, $expiredAt);
    }

    public function test_find_by_id_return_success()
    {
        $this->seed(CreateUserWithTokenSeeder::class);

        $user = User::first();

        $response = $this->apiTokenRepository->findById($user->id);

        $this->assertInstanceOf(stdClass::class, $response);
        $this->assertEquals($user->name, $response->name);
    }

    public function test_find_by_id_resturn_null()
    {
        $response = $this->apiTokenRepository->findById(1);

        $this->assertNull($response);
    }

    public function test_find_by_token_success()
    {
        $this->seed(CreateUserWithTokenSeeder::class);
        $user = ApiToken::first();

        $response = $this->apiTokenRepository->findByToken($user->token);

        $this->assertInstanceOf(stdClass::class, $response);
    }
}
