<?php

namespace Tests\Feature\Livewire\ModernArt\Category;

use App\Livewire\ModernArt\Category\CreateCategoryModal;
use App\Models\User;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateCategoryModalTest extends TestCase
{
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserSeeder::class);
        $this->user = User::first();
        $this->actingAs($this->user);
    }

    public function test_renders_successfully()
    {
        Livewire::test(CreateCategoryModal::class)
            ->assertStatus(200);
    }

    public function test_create_but_validate_error()
    {
        Livewire::test(CreateCategoryModal::class)
            ->call('save')
            ->assertHasErrors(['name', 'type']);
    }

    public function test_create_success()
    {
        Livewire::test(CreateCategoryModal::class)
            ->set('name', 'makanan')
            ->set('type', 'spending')
            ->call('save')
            ->assertHasNoErrors(['name', 'type'])
            ->assertDispatched('show-create-category-success');

        $this->assertDatabaseHas('categories', [
            'user_id' => $this->user->id,
            'name' => 'makanan',
            'type' => 'spending',
        ]);
    }
}
