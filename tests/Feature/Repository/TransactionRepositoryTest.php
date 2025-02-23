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

    public function test_find_by_code_success()
    {
        $this->seed(CreateTransactionSeeder::class);
        $transaction = Transaction::first();

        $response = $this->transactionRepository->findByCode($this->user->id, $transaction->code);

        $this->assertInstanceOf(Transaction::class, $response);
        $this->assertEquals($transaction->description, $response->description);
        $this->assertEquals($transaction->income, $response->income);
        $this->assertEquals($transaction->spending, $response->spending);
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

    public function test_get_summary_income_spending_success()
    {
        $this->seed(CreateTransactionSeeder::class);
        $this->seed(CreateTransactionSeeder::class);
        $this->seed(CreateTransactionSeeder::class);

        $response = $this->transactionRepository->getSummaryIncomeSpending($this->user->id);

        $this->assertInstanceOf(Collection::class, $response);

        $this->assertObjectHasProperty('date', $response->first());
        $this->assertObjectHasProperty('total_income', $response->first());
        $this->assertObjectHasProperty('total_spending', $response->first());
    }

    public function test_update_success()
    {
        $this->seed(CreateTransactionSeeder::class);
        $this->seed(CreateTransactionSeeder::class);
        $this->seed(CreateTransactionSeeder::class);
        $transaction = Transaction::first();

        $input = new TransactionDomain();
        $input->userId = $this->user->id;
        $input->code = $transaction->code;
        $input->periodId = $transaction->period_id;
        $input->categoryId = $transaction->category_id;
        $input->date = Carbon::create($transaction->date);
        $input->description = 'contoh-nama';
        $input->income = $transaction->income == 0 ? 0 : 50000;
        $input->spending = $transaction->spending == 0 ? 0 : 50000;

        $response = $this->transactionRepository->update($input);

        $this->assertInstanceOf(Transaction::class, $response);
        $this->assertDatabaseHas('transactions', [
            'code' => $transaction->code,
            'description' => 'contoh-nama'
        ]);
    }

    public function test_delete_success()
    {
        $this->seed(CreateTransactionSeeder::class);
        $transaction = Transaction::first();

        $this->transactionRepository->delete($this->user->id, $transaction->code);

        $this->assertDatabaseCount('transactions', 0);
    }
}
