<?php

namespace Tests\Feature\Repository;

use App\Models\ApiToken;
use App\Models\User;
use App\RepositoryInterface\ApiTokenRepositoryInterface;
use App\RepositoryInterface\UserRepositoryInterface;
use Carbon\Carbon;
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

        $this->assertInstanceOf(stdClass::class, $response);
        $this->assertEquals($response->user_id, $user->id);
        $this->assertEquals($response->token, $token);
        $this->assertEquals($response->expired_at, $expiredAt);
        $this->assertEquals($response->name, $user->name);
        $this->assertEquals($response->email, $user->email);
    }
}
