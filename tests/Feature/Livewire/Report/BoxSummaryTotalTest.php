<?php

namespace Tests\Feature\Livewire\Report;

use App\Livewire\Report\BoxSummaryTotal;
use App\Models\User;
use Database\Seeders\CreateCategorySeeder;
use Database\Seeders\CreateTransactionSeeder;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BoxSummaryTotalTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserSeeder::class);
        $user = User::first();
        $this->actingAs($user);
    }

    public function test_renders_successfully()
    {
        Livewire::test(BoxSummaryTotal::class)
            ->assertStatus(200);
    }

    public function test_renders_with_data()
    {
        $this->seed(CreateCategorySeeder::class);
        $this->seed(CreateTransactionSeeder::class);

        Livewire::test(BoxSummaryTotal::class)
            ->assertStatus(200);
    }
}
