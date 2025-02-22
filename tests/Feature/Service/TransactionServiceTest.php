<?php

namespace Tests\Feature\Service;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use App\Service\TransactionService;
use Carbon\Carbon;
use Database\Seeders\CreateCategorySeeder;
use Database\Seeders\CreateTransactionSeeder;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
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

    public function test_find_by_code_success()
    {
        $this->seed(CreateTransactionSeeder::class);
        $transaction = Transaction::first();

        $response = $this->transactionService->findByCode($this->user->id, $transaction->code);

        $this->assertInstanceOf(Transaction::class, $response);
        $this->assertEquals($response, $transaction);
        $this->assertEquals($response->description, $transaction->description);
    }

    public function test_get_by_date_success()
    {
        $this->seed(CreateTransactionSeeder::class);
        $transaction = Transaction::first();

        $response = $this->transactionService->getByDate($this->user->id, Carbon::create($transaction->date));

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals($response->count(), 1);
    }

    public function test_update_success()
    {
        $this->seed(CreateTransactionSeeder::class);
        $this->seed(CreateTransactionSeeder::class);
        $this->seed(CreateTransactionSeeder::class);

        $transaction = Transaction::first();

        $response = $this->transactionService->update(
            $this->user->id,
            $transaction->code,
            $this->category->id,
            '2025-10-10',
            'example-name',
            $this->category->type == 'income' ? 25000 : 0,
            $this->category->type == 'spending' ? 25000 : 0,
        );

        $this->assertInstanceOf(Transaction::class, $response);
        $this->assertDatabaseHas('transactions', [
            'code' => $transaction->code,
            'description' => 'example-name'
        ]);
    }

    public function test_delete_success()
    {
        $this->seed(CreateTransactionSeeder::class);
        $this->seed(CreateTransactionSeeder::class);
        $this->seed(CreateTransactionSeeder::class);

        $transaction = Transaction::first();

        $this->assertDatabaseHas('transactions', [
            'code' => $transaction->code
        ]);

        $this->transactionService->delete($this->user->id, $transaction->code);

        $this->assertDatabaseMissing('transactions', [
            'code' => $transaction->code
        ]);
        $this->assertDatabaseCount('transactions', 2);
    }
}
