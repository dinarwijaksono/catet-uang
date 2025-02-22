<?php

namespace Tests\Feature\Livewire\Transaction;

use App\Livewire\Transaction\BoxTransactionInDate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BoxTransactionInDateTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(BoxTransactionInDate::class)
            ->assertStatus(200);
    }
}
