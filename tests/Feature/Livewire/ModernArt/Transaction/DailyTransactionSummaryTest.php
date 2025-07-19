<?php

namespace Tests\Feature\Livewire\ModernArt\Transaction;

use App\Livewire\ModernArt\Transaction\DailyTransactionSummary;
use App\Models\User;
use Database\Seeders\CreateCategorySeeder;
use Database\Seeders\CreateTransactionSeeder;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DailyTransactionSummaryTest extends TestCase
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
        Livewire::test(DailyTransactionSummary::class)
            ->assertStatus(200);
    }


    public function test_render_with_data()
    {
        $this->seed(CreateCategorySeeder::class);
        $this->seed(CreateTransactionSeeder::class);

        Livewire::test(DailyTransactionSummary::class)
            ->assertStatus(200);
    }
}
