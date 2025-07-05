<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\ApiToken;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\CreateCategorySeeder;
use Database\Seeders\CreateTransactionSeeder;
use Database\Seeders\CreateUserWithTokenSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionControllerApiTest extends TestCase
{
    protected $user;
    protected $token;
    protected $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserWithTokenSeeder::class);
        $this->user = User::first();
        $this->token = ApiToken::first();

        $this->seed(CreateCategorySeeder::class);
        $this->category = Category::all();
    }

    public function test_create_validate_error(): void
    {
        $response = $this->withHeader('api-token', $this->token->token)->post('/api/transaction');

        $response->assertStatus(400);
        $response->assertJsonStructure(['errors' => ['date', 'type', 'category', 'value', 'description']]);
    }

    public function test_create_success()
    {
        $response = $this->withHeader('api-token', $this->token->token)->post('/api/transaction', [
            'date' => '2025-07-15',
            'type' => 'income',
            'category' => $this->category->where('type', 'income')->first()->id,
            'value' => 20000,
            'description' => 'example description'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('transactions', [
            'description' => 'example description',
            'income' => 20000,
            'spending' => 0
        ]);

        $response = $this->withHeader('api-token', $this->token->token)->post('/api/transaction', [
            'date' => '2025-07-15',
            'type' => 'spending',
            'category' => $this->category->where('type', 'spending')->first()->id,
            'value' => 20000,
            'description' => 'example description 2'
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('transactions', [
            'description' => 'example description 2',
            'income' => 0,
            'spending' => 20000
        ]);
    }


    public function test_get_by_date_success()
    {
        $this->seed(CreateTransactionSeeder::class);
        $this->seed(CreateTransactionSeeder::class);

        $response = $this->withHeader('api-token', $this->token->token)->get("/api/transaction/get-by-date/2024-01-01");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                [
                    'category_name',
                    'period_date',
                    'period_name',
                    'code',
                    'date',
                    'description',
                    'income',
                    'spending'
                ]
            ],
            'transaction_count'
        ]);
        $response->assertJsonPath('transaction_count', 2);
    }
}
