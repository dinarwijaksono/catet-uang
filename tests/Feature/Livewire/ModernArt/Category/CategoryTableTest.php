<?php

namespace Tests\Feature\Livewire\ModernArt\Category;

use App\Livewire\ModernArt\Category\CategoryTable;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Database\Seeders\CreateCategorySeeder;
use Database\Seeders\CreateTransactionSeeder;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryTableTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserSeeder::class);
        $this->user = User::first();
        $this->actingAs($this->user);
    }

    public function test_renders_successfully()
    {
        Livewire::test(CategoryTable::class)
            ->assertStatus(200);
    }

    public function test_delete_but_category_still_use()
    {
        $this->seed(CreateCategorySeeder::class);

        $this->seed(CreateTransactionSeeder::class);
        $transaction = Transaction::first();

        $category = Category::where('id', $transaction->category_id)->first();

        Livewire::test(CategoryTable::class)
            ->call('doDelete', $category->code)
            ->assertDispatched('show-delete-category-failed');
    }

    public function test_delete_success()
    {
        $this->seed(CreateCategorySeeder::class);
        $category = Category::first();

        Livewire::test(CategoryTable::class)
            ->call('doDelete', $category->code)
            ->assertDispatched('show-delete-category-success');
    }
}
