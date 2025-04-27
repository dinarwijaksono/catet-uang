<?php

namespace Tests\Feature\Livewire\Category;

use App\Livewire\Category\BoxListCategory;
use App\Livewire\Category\FormUpdateCategory;
use App\Livewire\Component\AlertSuccess;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\CreateCategorySeeder;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FormUpdateCategoryTest extends TestCase
{
    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserSeeder::class);
        $this->user = User::first();
        $this->actingAs($this->user);
    }

    public function test_renders_successfully()
    {
        Livewire::test(FormUpdateCategory::class)
            ->assertStatus(200);
    }

    public function test_update_success()
    {
        $this->seed(CreateCategorySeeder::class);
        $category = Category::first();

        Livewire::test(FormUpdateCategory::class)
            ->set('categoryCode', $category->code)
            ->set('name', 'tagihan')
            ->call('save')
            ->assertDispatched('do-hide')
            ->assertDispatchedTo(AlertSuccess::class, 'do-hide')
            ->assertDispatchedTo(BoxListCategory::class, 'do-refresh')
            ->assertDispatchedTo(AlertSuccess::class, 'do-show');

        $this->assertDatabaseHas('categories', [
            'user_id' => $this->user->id,
            'name' => 'tagihan',
            'type' => $category->type
        ]);
    }

    public function test_create_category_but_validate_error()
    {
        Livewire::test(FormUpdateCategory::class)
            ->call('save')
            ->assertHasErrors(['name']);
    }
}
