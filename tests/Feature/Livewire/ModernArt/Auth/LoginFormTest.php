<?php

namespace Tests\Feature\Livewire\ModernArt\Auth;

use App\Livewire\ModernArt\Auth\LoginForm;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class LoginFormTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(LoginForm::class)
            ->assertStatus(200);
    }

    public function test_login_but_validate_error()
    {
        Livewire::test(LoginForm::class)
            ->set('email', '')
            ->set('password', '')
            ->call('doLogin')
            ->assertHasErrors(['email', 'password']);
    }

    public function test_login_but_email_not_exist()
    {
        Livewire::test(LoginForm::class)
            ->set('email', 'test@gmail.com')
            ->set('password', 'rahasia1234')
            ->call('doLogin')
            ->assertDispatched('show-login-failed');
    }

    public function test_login_success()
    {
        $this->seed(CreateUserSeeder::class);

        Livewire::test(LoginForm::class)
            ->set('email', 'test@gmail.com')
            ->set('password', 'rahasia1234')
            ->call('doLogin')
            ->assertHasNoErrors(['email', 'password']);
    }
}
