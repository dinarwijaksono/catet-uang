<?php

namespace Tests\Feature\Livewire\Component;

use App\Livewire\Component\AlertDanger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class AlertDangerTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(AlertDanger::class)
            ->assertStatus(200);
    }
}
