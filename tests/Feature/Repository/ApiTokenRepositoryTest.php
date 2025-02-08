<?php

namespace Tests\Feature\Repository;

use App\Models\ApiToken;
use App\RepositoryInterface\ApiTokenRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ApiTokenRepositoryTest extends TestCase
{
    protected $apiTokenRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->apiTokenRepository = $this->app->make(ApiTokenRepositoryInterface::class);
    }

    public function test_create_success(): void
    {
        $userId = 1;
        $token = Str::random(32);
        $expiredAt = Carbon::now()->addDays(3);

        $response = $this->apiTokenRepository->create($userId, $token, $expiredAt);

        $this->assertDatabaseHas('api_tokens', [
            'user_id' => $userId,
            'token' => $token,
            'expired_at' => $expiredAt
        ]);

        $this->assertInstanceOf(ApiToken::class, $response);
        $this->assertEquals($response->user_id, $userId);
        $this->assertEquals($response->token, $token);
        $this->assertEquals($response->expired_at, $expiredAt);
    }
}
