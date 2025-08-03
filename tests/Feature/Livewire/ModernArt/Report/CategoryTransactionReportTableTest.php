<?php

namespace Tests\Feature\Livewire\ModernArt\Report;

use App\Livewire\ModernArt\Report\CategoryTransactionReportTable;
use App\Models\User;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryTransactionReportTableTest extends TestCase
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
        Livewire::test(CategoryTransactionReportTable::class)
            ->assertStatus(200);
    }
}
