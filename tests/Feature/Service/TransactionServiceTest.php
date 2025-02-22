<?php

namespace Tests\Feature\Service;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use App\Service\TransactionService;
use Database\Seeders\CreateCategorySeeder;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    public $user;
    public $category;

    public $transactionService;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserSeeder::class);
        $this->user = User::first();

        $this->seed(CreateCategorySeeder::class);
        $this->category = Category::first();

        $this->transactionService = $this->app->make(TransactionService::class);
    }

    public function test_create_spending_success()
    {
        $response = $this->transactionService->create($this->user->id, $this->category->id, "2024-05-28", "makan siang", 0, 15000);

        $this->assertInstanceOf(Transaction::class, $response);
        $this->assertDatabaseCount('periods', 1);
        $this->assertDatabaseCount('transactions', 1);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'description' => "makan siang",
            'income' => 0,
            'spending' => 15000
        ]);
    }

    public function test_create_income_success()
    {
        $response = $this->transactionService->create($this->user->id, $this->category->id, "2024-05-28", "Gaji", 2000000, 0);

        $this->assertInstanceOf(Transaction::class, $response);
        $this->assertDatabaseCount('periods', 1);
        $this->assertDatabaseCount('transactions', 1);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'description' => "Gaji",
            'income' => 2000000,
            'spending' => 0
        ]);
    }
}
