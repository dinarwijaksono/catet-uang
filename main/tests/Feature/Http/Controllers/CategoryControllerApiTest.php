<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ApiToken;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\CreateCategorySeeder;
use Database\Seeders\CreateUserWithTokenSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerApiTest extends TestCase
{
    protected $user;
    protected $token;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserWithTokenSeeder::class);
        $this->user = User::first();
        $this->token = ApiToken::first();
    }

    public function test_created_but_validate_error(): void
    {
        $response = $this->withHeader('api-token', $this->token->token)
            ->post('/api/category');

        $response->assertStatus(400);
        $response->assertJsonStructure(['errors' => ['name', 'type']]);
    }

    public function test_created_success()
    {
        $response = $this->withHeader('api-token', $this->token->token)
            ->post('/api/category', [
                'name' => 'example',
                'type' => 'income'
            ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => ['code', 'name', 'type', 'created_at', 'updated_at']]);
        $response->assertJsonPath('data.name', 'example');
    }

    public function test_get_category_but_return_null()
    {
        $response = $this->withHeader('api-token', $this->token->token)
            ->get('/api/category/aaaa');

        $response->assertStatus(400);
        $response->assertJsonPath('message', 'Kategori tidak ditemukan.');
    }

    public function test_get_category_success()
    {
        $this->seed(CreateCategorySeeder::class);
        $category = Category::first();

        $response = $this->withHeader('api-token', $this->token->token)
            ->get("/api/category/$category->code");

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['id', 'name', 'type', 'created_at', 'updated_at']]);
    }

    public function test_get_all_but_category_null()
    {
        $response = $this->withHeader('api-token', $this->token->token)
            ->get('/api/category/get-all');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => []]);
        $response->assertJsonPath('category_count', 0);
    }

    public function test_get_all_success()
    {
        $this->seed(CreateCategorySeeder::class);
        $this->seed(CreateCategorySeeder::class);

        $response = $this->withHeader('api-token', $this->token->token)
            ->get('/api/category/get-all');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => [['code', 'name', 'type', 'created_at', 'updated_at']]]);
        $response->assertJsonPath('category_count', 4);
    }
}
