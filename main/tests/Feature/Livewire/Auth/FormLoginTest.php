<?php

namespace Tests\Feature\Livewire\Auth;

use App\Livewire\Auth\FormLogin;
use App\Models\User;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FormLoginTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(FormLogin::class)
            ->assertStatus(200);
    }

    public function test_login_success()
    {
        $this->seed(CreateUserSeeder::class);
        $user = User::first();

        Livewire::test(FormLogin::class)
            ->set('email', $user->email)
            ->set('password', 'rahasia1234')
            ->call('login')
            ->assertRedirect('/');

        $this->assertEquals(auth()->user()->name, $user->name);
        $this->assertEquals(auth()->user()->email, $user->email);
    }

    public function test_login_but_error_validate()
    {
        Livewire::test(FormLogin::class)
            ->set('email', '')
            ->set('password', '')
            ->call('login')
            ->assertHasErrors(['email', 'password']);
    }

    public function test_login_but_password_is_wrong()
    {
        $this->seed(CreateUserSeeder::class);
        $user = User::first();

        Livewire::test(FormLogin::class)
            ->set('email', $user->email)
            ->set('password', 'password is wrong')
            ->call('login')
            ->assertHasErrors(['general']);
    }

    public function test_login_but_email_is_wrong()
    {
        Livewire::test(FormLogin::class)
            ->set('email', 'example@gmail.com')
            ->set('password', 'rahasia1234')
            ->call('login')
            ->assertHasErrors(['general']);
    }
}
