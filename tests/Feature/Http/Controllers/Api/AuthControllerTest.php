<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\ApiToken;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\CreateUserSeeder;
use Database\Seeders\CreateUserWithTokenSeeder;
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

    public function test_login_return_success()
    {
        $this->seed(CreateUserSeeder::class);
        $user = User::first();

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'rahasia1234'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['api_token', 'expired_token', 'name', 'email']]);
        $response->assertJsonPath('data.name', $user->name);
    }

    public function test_login_return_validate_error()
    {
        $response = $this->post('/api/login', [
            'email' => '',
            'password' => ''
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['errors' => ['email', 'password']]);
    }

    public function test_login_return_validate_email_error()
    {
        $response = $this->post('/api/login', [
            'email' => 'emailIsWrong@gmail.com',
            'password' => 'rahasia1234'
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure(['errors' => ['general']]);
        $response->assertJsonPath('errors.general', "Email atau password salah.");
    }

    public function test_login_return_error_password_is_wrong()
    {
        $this->seed(CreateUserSeeder::class);
        $user = User::first();

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'this-password-wrong'
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure(['errors' => ['general']]);
        $response->assertJsonPath('errors.general', "Email atau password salah.");
    }

    public function test_login_but_has_token_and_not_expired()
    {
        $this->seed(CreateUserWithTokenSeeder::class);
        $user = User::first();

        $apiToken = ApiToken::first();

        $response = $this->withHeader('api-token', $apiToken->token)->post('/api/login', [
            'email' => $user->email,
            'password' => 'rahasia1234'
        ]);

        $response->assertStatus(403);
        $response->assertJsonStructure(['errors' => ['general']]);
        $response->assertJsonPath('errors.general', "Token belum expired.");
    }

    public function test_login_but_has_token_is_expired()
    {
        $this->seed(CreateUserWithTokenSeeder::class);
        $user = User::first();

        $apiToken = ApiToken::first();
        ApiToken::where('token', $apiToken->token)
            ->update(['expired_at' => Carbon::createFromDate('2025-01-01')]);

        $apiToken = ApiToken::first();

        $response = $this->withHeader('api-token', $apiToken->token)->post('/api/login', [
            'email' => $user->email,
            'password' => 'rahasia1234'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['api_token', 'expired_token', 'name', 'email']]);
        $response->assertJsonPath('data.name', $user->name);
    }
}
