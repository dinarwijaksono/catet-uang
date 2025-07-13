<?php

namespace Tests\Feature\Livewire\Transaction;

use App\Livewire\Component\AlertSuccess;
use App\Livewire\Transaction\BoxSummaryIncomeSpending;
use App\Livewire\Transaction\BoxTransactionInDate;
use App\Models\Transaction;
use App\Models\User;
use Database\Seeders\CreateCategorySeeder;
use Database\Seeders\CreateTransactionSeeder;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BoxTransactionInDateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserSeeder::class);
        $user = User::first();
        $this->actingAs($user);

        $this->seed(CreateCategorySeeder::class);
    }

    public function test_renders_successfully()
    {
        Livewire::test(BoxTransactionInDate::class)
            ->assertStatus(200);
    }

    public function test_renders_with_transaction()
    {
        $this->seed(CreateTransactionSeeder::class);
        $this->seed(CreateTransactionSeeder::class);
        $this->seed(CreateTransactionSeeder::class);

        Livewire::test(BoxTransactionInDate::class)
            ->assertStatus(200);
    }

    public function test_delete_success()
    {
        $this->seed(CreateTransactionSeeder::class);
        $this->seed(CreateTransactionSeeder::class);
        $this->seed(CreateTransactionSeeder::class);

        $transaction = Transaction::first();

        Livewire::test(BoxTransactionInDate::class)
            ->call('delete', $transaction->code)
            ->assertDispatchedTo(AlertSuccess::class, 'do-show', 'Kategori berhasil di hapus.');

        $this->assertDatabaseCount('transactions', 2);
    }
}
