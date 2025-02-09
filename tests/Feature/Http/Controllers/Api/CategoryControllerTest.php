<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\ApiToken;
use Carbon\Carbon;
use Database\Seeders\CreateUserWithTokenSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserWithTokenSeeder::class);
        $this->user = ApiToken::first();
    }

    public function test_create_success(): void
    {
        $name = 'makanan';
        $type = 'spending';

        $response = $this->withHeader('api-token', $this->user->token)
            ->post('/api/category', [
                'name' => $name,
                'type' => $type
            ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => ['code', 'name', 'type']]);
        $response->assertJsonPath('data.name', $name);
        $this->assertDatabaseHas('categories', [
            'name' => $name,
            'type' => $type
        ]);
    }

    public function test_create_return_validate_error()
    {
        $response = $this->withHeader('api-token', $this->user->token)
            ->post('/api/category', [
                'name' => '',
                'type' => ''
            ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['errors' => ['name', 'type']]);
    }

    public function test_create_return_token_not_valid(): void
    {
        $name = 'makanan';
        $type = 'spending';

        $response = $this->withHeader('api-token', "thistokeninvalid")
            ->post('/api/category', [
                'name' => $name,
                'type' => $type
            ]);

        $response->assertStatus(403);
        $response->assertJsonStructure(['errors' => ['general']]);
        $response->assertJsonPath('errors.general', "Token tidak valid.");
    }

    public function test_create_return_token_is_expired()
    {
        $name = 'makanan';
        $type = 'spending';

        ApiToken::where('token', $this->user->token)
            ->update(['expired_at' => Carbon::createFromDate('2025-01-01')]);

        $response = $this->withHeader('api-token', $this->user->token)
            ->post('/api/category', [
                'name' => $name,
                'type' => $type
            ]);

        $response->assertStatus(403);
        $response->assertJsonStructure(['errors' => ['general']]);
        $response->assertJsonPath('errors.general', "Token sudah expired.");
    }
}
