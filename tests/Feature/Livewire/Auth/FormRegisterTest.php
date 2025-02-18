<?php

namespace Tests\Feature\Livewire\Auth;

use App\Livewire\Auth\FormRegister;
use App\Models\User;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FormRegisterTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(FormRegister::class)
            ->assertStatus(200);
    }

    public function test_register_success()
    {
        Livewire::test(FormRegister::class)
            ->set('name', 'test')
            ->set('email', 'test@gmail.com')
            ->set('password', 'rahasia1234')
            ->set('confirmation_password', 'rahasia1234')
            ->call('save')
            ->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'name' => 'test',
            'email' => 'test@gmail.com'
        ]);
    }

    public function test_register_but_the_email_is_already_there()
    {
        $this->seed(CreateUserSeeder::class);
        $user = User::first();

        Livewire::test(FormRegister::class)
            ->set('name', 'test')
            ->set('email', $user->email)
            ->set('password', 'rahasia1234')
            ->set('confirmation_password', 'rahasia1234')
            ->call('save')
            ->assertHasErrors(['general']);

        $this->assertDatabaseCount('users', 1);
    }

    public function test_register_but_validate_error()
    {
        Livewire::test(FormRegister::class)
            ->set('name', '')
            ->set('email', '')
            ->set('password', '')
            ->set('confirmation_password', '')
            ->call('save')
            ->assertHasErrors(['name', 'email', 'password', 'confirmation_password']);
    }
}
