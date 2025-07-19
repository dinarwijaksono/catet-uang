<?php

namespace Tests\Feature\Livewire\ModernArt\Component;

use App\Livewire\ModernArt\Component\Navbar;
use App\Models\User;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Tests\TestCase;

class NavbarTest extends TestCase
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
        Livewire::test(Navbar::class)
            ->assertStatus(200);
    }

    public function test_hendle_button_logout()
    {
        Livewire::test(Navbar::class)
            ->call('hendleButtonLogout')
            ->assertDispatched('open-confirm-logout');
    }

    public function test_do_logout_success()
    {
        Livewire::test(Navbar::class)
            ->call('doLogout')
            ->assertRedirect('/');
    }
}
