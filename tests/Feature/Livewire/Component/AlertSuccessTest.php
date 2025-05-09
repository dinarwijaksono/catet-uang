<?php

namespace Tests\Feature\Livewire\Component;

use App\Livewire\Component\AlertSuccess;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class AlertSuccessTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(AlertSuccess::class)
            ->assertStatus(200);
    }
}
