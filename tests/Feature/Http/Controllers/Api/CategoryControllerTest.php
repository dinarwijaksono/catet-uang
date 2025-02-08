<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\ApiToken;
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
}
