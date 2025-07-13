<?php

namespace Tests\Feature\Livewire\Category;

use App\Livewire\Category\BoxListCategory;
use App\Livewire\Category\FormCreateCategory;
use App\Livewire\Component\AlertSuccess;
use App\Models\User;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FormCreateCategoryTest extends TestCase
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
        Livewire::test(FormCreateCategory::class)
            ->assertStatus(200);
    }

    public function test_create_success()
    {
        Livewire::test(FormCreateCategory::class)
            ->set('name', 'makanan')
            ->set('type', 'spending')
            ->call('save')
            ->assertDispatched('do-hide')
            ->assertDispatchedTo(AlertSuccess::class, 'do-hide')
            ->assertDispatchedTo(BoxListCategory::class, 'do-refresh')
            ->assertDispatchedTo(AlertSuccess::class, 'do-show');

        $this->assertDatabaseHas('categories', [
            'user_id' => $this->user->id,
            'name' => 'makanan',
            'type' => 'spending'
        ]);
    }

    public function test_create_category_but_validate_error()
    {
        Livewire::test(FormCreateCategory::class)
            ->call('save')
            ->assertHasErrors(['name']);
    }
}
