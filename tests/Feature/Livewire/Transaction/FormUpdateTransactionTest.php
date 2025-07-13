<?php

namespace Tests\Feature\Livewire\Transaction;

use App\Livewire\Component\AlertSuccess;
use App\Livewire\Transaction\BoxSummaryIncomeSpending;
use App\Livewire\Transaction\BoxTransactionInDate;
use App\Livewire\Transaction\FormCreateTransaction;
use App\Livewire\Transaction\FormUpdateTransaction;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\CreateCategorySeeder;
use Database\Seeders\CreateTransactionSeeder;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FormUpdateTransactionTest extends TestCase
{
    public $user;
    public $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserSeeder::class);
        $this->user = User::first();
        $this->actingAs($this->user);

        $this->seed(CreateCategorySeeder::class);
        $this->category = Category::first();
    }

    public function test_renders_successfully()
    {
        Livewire::test(FormUpdateTransaction::class)
            ->assertStatus(200);
    }

    public function test_update_transaction_success()
    {
        $this->seed(CreateTransactionSeeder::class);
        $transaction = Transaction::first();

        Livewire::test(FormUpdateTransaction::class)
            ->set('code', $transaction->code)
            ->set('date', '2025-01-11')
            ->set('type', 'spending')
            ->set('category', $this->category->id)
            ->set('value', 2500)
            ->set('description', "makan siang")
            ->call('save')
            ->assertDispatchedTo(AlertSuccess::class, 'do-show', "Transaksi berhasil diedit.")
            ->assertDispatchedTo(BoxTransactionInDate::class, 'do-refresh')
            ->assertDispatchedTo(BoxSummaryIncomeSpending::class, 'do-refresh');

        $this->assertDatabaseHas('transactions', [
            'code' => $transaction->code,
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'date' => Carbon::createFromFormat('Y-m-d', "2025-01-11")->setTime(0, 0, 0, 0),
            'income' => 0,
            'spending' => 2500,
            'description' => 'makan siang'
        ]);
    }
}
