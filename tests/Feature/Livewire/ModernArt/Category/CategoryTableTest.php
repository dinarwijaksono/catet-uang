<?php

namespace Tests\Feature\Livewire\ModernArt\Category;

use App\Livewire\ModernArt\Category\CategoryTable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryTableTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(CategoryTable::class)
            ->assertStatus(200);
    }
}
