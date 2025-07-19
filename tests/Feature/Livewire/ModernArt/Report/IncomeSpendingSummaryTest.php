<?php

namespace Tests\Feature\Livewire\ModernArt\Report;

use App\Livewire\ModernArt\Report\IncomeSpendingSummary;
use App\Models\User;
use Database\Seeders\CreateCategorySeeder;
use Database\Seeders\CreateTransactionSeeder;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class IncomeSpendingSummaryTest extends TestCase
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
        Livewire::test(IncomeSpendingSummary::class)
            ->assertStatus(200);
    }

    public function test_renders_with_data()
    {
        $this->seed(CreateCategorySeeder::class);
        $this->seed(CreateTransactionSeeder::class);

        Livewire::test(IncomeSpendingSummary::class)
            ->assertStatus(200);
    }
}
