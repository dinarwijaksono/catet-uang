<?php

namespace Tests\Feature\Livewire\Category;

use App\Livewire\Category\BoxListCategory;
use App\Livewire\Category\FormCreateCategory;
use App\Livewire\Component\AlertDanger;
use App\Livewire\Component\AlertSuccess;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\CreateCategorySeeder;
use Database\Seeders\CreateTransactionSeeder;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BoxListCategoryTest extends TestCase
{
    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserSeeder::class);
        $this->user = User::first();
        $this->actingAs($this->user);
    }

    public function test_renders_with_empty_category()
    {
        Livewire::test(BoxListCategory::class)
            ->assertStatus(200);
    }

    public function test_renders_with_category_is_there()
    {
        $this->seed(CreateCategorySeeder::class);
        $this->seed(CreateCategorySeeder::class);

        Livewire::test(BoxListCategory::class)
            ->assertStatus(200);
    }

    public function test_to_show_form_create_category()
    {
        Livewire::test(BoxListCategory::class)
            ->call('toShowFormCreateCategory')
            ->assertDispatchedTo(FormCreateCategory::class, 'do-show');
    }

    public function test_delete_category_success()
    {
        $this->seed(CreateCategorySeeder::class);
        $this->seed(CreateCategorySeeder::class);

        $category = Category::first();

        Livewire::test(BoxListCategory::class)
            ->call('deleteCategory', $category->first()->code)
            ->assertDispatchedTo(AlertSuccess::class, 'do-show');

        $this->assertDatabaseMissing('categories', [
            'user_id' => $this->user->id,
            'code' => $category->code
        ]);
    }

    public function test_delete_category_but_category_still_use()
    {
        $this->seed(CreateCategorySeeder::class);
        $this->seed(CreateTransactionSeeder::class);

        $category = Category::first();

        Livewire::test(BoxListCategory::class)
            ->call('deleteCategory', $category->first()->code)
            ->assertDispatchedTo(AlertDanger::class, 'do-show', "Kategori gagal dihapus, karena kategori digunakan pada transaksi.");

        $this->assertDatabaseHas('categories', [
            'user_id' => $this->user->id,
            'code' => $category->code
        ]);
    }

    public function test_delete_categorY_but_category_noting_in_database()
    {
        Livewire::test(BoxListCategory::class)
            ->call('deleteCategory', 'category-code')
            ->assertDispatchedTo(AlertDanger::class, 'do-show', "Kategori gagal dihapus, karena kategori digunakan pada transaksi.");
    }
}
