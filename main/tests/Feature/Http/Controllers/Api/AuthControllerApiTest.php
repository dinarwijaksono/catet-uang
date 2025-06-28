<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerApiTest extends TestCase
{
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
}
