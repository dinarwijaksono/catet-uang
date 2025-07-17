<?php

namespace Tests\Feature\Livewire\ModernArt\Transaction;

use App\Livewire\ModernArt\Transaction\CreateTransactionModal;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\CreateCategorySeeder;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTransactionModalTest extends TestCase
{
    private $user;
    private $category;

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
        Livewire::test(CreateTransactionModal::class, ['date' => date('Y-m-d')])
            ->assertStatus(200);
    }

    public function test_create_but_validate_error()
    {
        Livewire::test(CreateTransactionModal::class, ['date' => date('Y-m-d')])
            ->call('save')
            ->assertHasErrors(['type', 'category', 'value', 'description']);
    }

    public function test_create_success()
    {
        Livewire::test(CreateTransactionModal::class, ['date' => date('Y-m-d')])
            ->set('date', '2025-01-01')
            ->set('type', $this->category->type)
            ->set('category', $this->category->id)
            ->set('value', 350)
            ->set('description', 'test')
            ->call('save')
            ->assertHasNoErrors(['date', 'type', 'category', 'value', 'description'])
            ->assertDispatched('show-create-transaction-success');

        $this->assertDatabaseHas('transactions', [
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'income' => $this->category->type == 'income' ? 350 : 0,
            'spending' => $this->category->type == 'sending' ? 350 : 0,
            'description' => 'test',
        ]);
    }
}
