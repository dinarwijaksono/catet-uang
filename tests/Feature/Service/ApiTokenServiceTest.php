<?php

namespace Tests\Feature\Service;

use App\Models\ApiToken;
use App\Models\User;
use App\Service\ApiTokenService;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTokenServiceTest extends TestCase
{
    public $user;

    protected $apiTokenService;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserSeeder::class);
        $this->user = User::first();

        $this->apiTokenService = app()->make(ApiTokenService::class);
    }

    public function test_create_api_token_success(): void
    {
        $response = $this->apiTokenService->create($this->user->id);

        $this->assertInstanceOf(ApiToken::class, $response);
        $this->assertDatabaseHas('api_tokens', [
            'user_id' => $this->user->id,
        ]);
    }
}
