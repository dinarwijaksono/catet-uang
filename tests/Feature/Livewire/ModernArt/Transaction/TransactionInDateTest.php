<?php

namespace Tests\Feature\Livewire\ModernArt\Transaction;

use App\Livewire\ModernArt\Transaction\DailyTransactionSummary;
use App\Livewire\ModernArt\Transaction\TransactionInDate;
use App\Models\Transaction;
use App\Models\User;
use Database\Seeders\CreateCategorySeeder;
use Database\Seeders\CreateTransactionSeeder;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TransactionInDateTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserSeeder::class);
        $this->user = User::first();
        $this->actingAs($this->user);

        $this->seed(CreateCategorySeeder::class);
    }

    public function test_renders_successfully()
    {
        Livewire::test(TransactionInDate::class, ['date' => date('Y-m-d')])
            ->assertStatus(200);
    }

    public function test_render_but_transaction_is_exist()
    {
        $this->seed(CreateTransactionSeeder::class);
        $this->seed(CreateTransactionSeeder::class);
        $this->seed(CreateTransactionSeeder::class);

        $transaction = Transaction::first();

        Livewire::test(TransactionInDate::class, ['date' => date('Y-m-d', strtotime($transaction->date))])
            ->assertStatus(200);
    }

    public function test_do_delete_success()
    {
        $this->seed(CreateTransactionSeeder::class);
        $transaction = Transaction::first();

        Livewire::test(TransactionInDate::class, ['date' => date('Y-m-d', strtotime($transaction->date))])
            ->call('doDelete', $transaction->code)
            ->assertDispatched('do-refresh');

        $this->assertDatabaseMissing('transactions', [
            'code' => $transaction->code
        ]);
    }
}
