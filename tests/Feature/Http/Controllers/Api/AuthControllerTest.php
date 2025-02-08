<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function test_register_success(): void
    {
        $name = 'test';
        $email = 'test@gmail.com';
        $password = 'rahasia1234';
        $confirmationPassword = 'rahasia1234';

        $response = $this->post('/api/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'confirmation_password' => $confirmationPassword
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['data' => ['api_token', 'expired_token', 'name', 'email']]);
        $response->assertJsonPath('data.name', $name);
        $response->assertJsonPath('data.email', $email);
    }

    public function test_register_fail_with_validate_error()
    {
        $response = $this->post('/api/register', [
            'name' => '',
            'email' => '',
            'password' => 'rahasia1234',
            'confirmation_password' => 'rahasia'
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['errors' => ['name', 'email', 'confirmation_password']]);
    }

    public function test_register_fail_with_email_duplicate()
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('rahasia1234')
        ]);

        $response = $this->post('/api/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'rahasia1234',
            'confirmation_password' => 'rahasia1234'
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure(['errors' => ['general']]);
        $response->assertJsonPath('errors.general', "Email tidak tersedia.");
    }
}
