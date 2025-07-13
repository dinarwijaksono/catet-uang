<?php

namespace Tests\Feature\Livewire\ModernArt\Auth;

use App\Livewire\ModernArt\Auth\RegisterForm;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class RegisterFormTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(RegisterForm::class)
            ->assertStatus(200);
    }

    public function test_register_but_validate_error()
    {
        Livewire::test(RegisterForm::class)
            ->set('name', '')
            ->set('email', '')
            ->set('password', '')
            ->set('confirmation_password', '')
            ->call('doRegister')
            ->assertHasErrors(['name', 'email', 'password', 'confirmation_password']);
    }

    public function test_register_but_email_is_exist()
    {
        $this->seed(CreateUserSeeder::class);

        Livewire::test(RegisterForm::class)
            ->set('name', 'test')
            ->set('email', 'test@gmail.com')
            ->set('password', 'rahasia1234')
            ->set('confirmation_password', 'rahasia1234')
            ->call('doRegister')
            ->assertDispatched('show-register-failed');
    }

    public function test_register_success()
    {
        Livewire::test(RegisterForm::class)
            ->set('name', 'test')
            ->set('email', 'test@gmail.com')
            ->set('password', 'rahasia1234')
            ->set('confirmation_password', 'rahasia1234')
            ->call('doRegister')
            ->assertHasNoErrors(['name', 'email', 'password', 'confirmation_password']);

        $this->assertDatabaseHas('users', [
            'name' => 'test',
            'email' => 'test@gmail.com',
        ]);
    }
}
