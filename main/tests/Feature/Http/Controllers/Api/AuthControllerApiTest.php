<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\ApiToken;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\CreateUserSeeder;
use Database\Seeders\CreateUserWithTokenSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerApiTest extends TestCase
{
    public function test_register_but_validate_is_error()
    {
        $response = $this->post('/api/register');

        $response->assertStatus(422);
        $response->assertJsonStructure(['errors' => ['name', 'email', 'password', 'confirmation_password']]);
    }

    public function test_register_but_email_is_exist()
    {
        $this->seed(CreateUserSeeder::class);

        $response = $this->post('/api/register', [
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'rahasia1',
            'confirmation_password' => 'rahasia1'
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['errors' => ['email']]);
        $response->assertJsonPath('errors.email.0', 'Email tidak tersedia.');
    }

    public function test_register_success(): void
    {
        $response = $this->post('/api/register', [
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => 'rahasia1',
            'confirmation_password' => 'rahasia1'
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => ['api_token', 'expired_token', 'name', 'email']
        ]);
        $response->assertJsonPath('data.name', 'test');
        $response->assertJsonPath('data.email', 'test@gmail.com');
        $this->assertDatabaseHas('users', [
            'name' => 'test',
            'email' => 'test@gmail.com'
        ]);

        $user = User::where('email', 'test@gmail.com')->first();

        $this->assertDatabaseHas('api_tokens', [
            'user_id' => $user->id
        ]);
    }

    public function test_login_but_validate_error()
    {
        $response = $this->post('/api/login');

        $response->assertStatus(422);
        $response->assertJsonStructure(['errors' => ['email', 'password']]);
    }

    public function test_login_but_email_not_exist()
    {
        $response = $this->post('/api/login', [
            'email' => 'emailNotExist@gmail.com',
            'password' => 'rahasia'
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure(['errors' => ['general']]);
        $response->assertJsonPath('errors.general.0', 'Email atau password salah.');
    }

    public function test_login_but_password_is_wrong()
    {
        $this->seed(CreateUserSeeder::class);

        $response = $this->post('/api/login', [
            'email' => 'test@gmail.com',
            'password' => 'passwordiswrong'
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure(['errors' => ['general']]);
        $response->assertJsonPath('errors.general.0', 'Email atau password salah.');
    }

    public function test_login_success()
    {
        $this->seed(CreateUserSeeder::class);

        $response = $this->post('/api/login', [
            'email' => 'test@gmail.com',
            'password' => 'rahasia1234'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['api_token', 'expired_token', 'name', 'email']]);
    }

    public function test_get_user_with_token_but_token_empty()
    {
        $response = $this->get('/api/user');

        $response->assertStatus(401);
        $response->assertJsonPath('message', 'Token tidak valid.');
    }

    public function test_get_user_with_token_but_token_invalid()
    {
        $response = $this->withHeader('api-token', 'token-invalid')->get('/api/user');

        $response->assertStatus(401);
        $response->assertJsonPath('message', 'Token tidak valid.');
    }

    public function test_get_user_with_token_but_token_has_expired()
    {
        $this->seed(CreateUserWithTokenSeeder::class);
        $token = ApiToken::first();

        ApiToken::where('token', $token->token)->update([
            'expired_at' => Carbon::now()->subDays(10)
        ]);

        $response = $this->withHeader('api-token', $token->token)->get('/api/user');

        $response->assertStatus(419);
        $response->assertJsonPath('message', 'Token sudah expired.');
    }

    public function test_get_user_with_token_success()
    {
        $this->seed(CreateUserWithTokenSeeder::class);
        $token = ApiToken::first();

        $response = $this->withHeader('api-token', $token->token)->get('/api/user');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['name', 'email', 'created_at']]);
    }
}
