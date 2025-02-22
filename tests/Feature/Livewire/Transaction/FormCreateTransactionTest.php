<?php

namespace Tests\Feature\Livewire\Transaction;

use App\Livewire\Component\AlertSuccess;
use App\Livewire\Transaction\BoxTransactionInDate;
use App\Livewire\Transaction\FormCreateTransaction;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\CreateCategorySeeder;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FormCreateTransactionTest extends TestCase
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
        Livewire::test(FormCreateTransaction::class)
            ->assertStatus(200);
    }

    public function test_create_transaction_success()
    {
        Livewire::test(FormCreateTransaction::class)
            ->set('date', '2025-01-05')
            ->set('type', 'spending')
            ->set('category', $this->category->id)
            ->set('value', 10000)
            ->set('description', "makan malam")
            ->call('save')
            ->assertDispatchedTo(AlertSuccess::class, 'do-show', "Transaksi berhasil di tambahkan.")
            ->assertDispatchedTo(BoxTransactionInDate::class, 'do-refresh');

        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'date' => Carbon::createFromFormat('Y-m-d', "2025-01-05")->setTime(0, 0, 0, 0),
            'income' => 0,
            'spending' => 10000,
            'description' => 'makan malam'
        ]);
    }
}
