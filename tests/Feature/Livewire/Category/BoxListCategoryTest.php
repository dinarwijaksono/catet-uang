<?php

namespace Tests\Feature\Livewire\Category;

use App\Livewire\Category\BoxListCategory;
use App\Models\User;
use Database\Seeders\CreateCategorySeeder;
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
}
