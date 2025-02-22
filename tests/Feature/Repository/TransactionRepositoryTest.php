<?php

namespace Tests\Feature\Repository;

use App\Domain\TransactionDomain;
use App\Models\Category;
use App\Models\Period;
use App\Models\Transaction;
use App\Models\User;
use App\RepositoryInterface\TransactionRepositoryInterface;
use Carbon\Carbon;
use Database\Seeders\CreateCategorySeeder;
use Database\Seeders\CreateTransactionSeeder;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class TransactionRepositoryTest extends TestCase
{
    protected $user;
    protected $category;

    protected $transactionRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserSeeder::class);
        $this->user = User::first();

        $this->seed(CreateCategorySeeder::class);
        $this->category = Category::first();

        $this->transactionRepository = app()->make(TransactionRepositoryInterface::class);
    }

    public function test_create_transaction_success()
    {
        $date = Carbon::createFromDate(2024, 1, 1);

        $period = Period::create([
            'user_id' => $this->user->id,
            'period_date' => strtotime("2024-01-01"),
            'period_name' => date("F Y", strtotime("2024-01-01")),
            'is_close' => false
        ]);

        $input = new TransactionDomain();
        $input->userId = $this->user->id;
        $input->periodId = $period->id;
        $input->categoryId = $this->category->id;
        $input->code = Str::random(10);
        $input->date = $date;
        $input->description = 'makan siang';
        $input->income = 0;
        $input->spending = 15000;

        $response = $this->transactionRepository->create($input);

        $this->assertInstanceOf(Transaction::class, $response);
        $this->assertDatabaseCount('transactions', 1);
        $this->assertDatabaseHas('transactions', [
            'code' => $input->code,
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'description' => 'makan siang',
            'income' => 0,
            'spending' => 15000,
        ]);
    }

    public function test_find_by_date_success()
    {
        $this->seed(CreateTransactionSeeder::class);
        $this->seed(CreateTransactionSeeder::class);
        $this->seed(CreateTransactionSeeder::class);
        $transaction = Transaction::first();

        $response = $this->transactionRepository->getByDate($this->user->id, Carbon::create($transaction->date));

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals($response->count(), 3);
    }
}
