<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function test_render_login()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_render_login_but_has_session()
    {
        $this->seed(CreateUserSeeder::class);
        $user = User::first();
        $this->actingAs($user);

        $response = $this->get('/login');

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function test_render_register()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_render_register_but_has_session()
    {
        $this->seed(CreateUserSeeder::class);
        $user = User::first();
        $this->actingAs($user);

        $response = $this->get('/register');

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function test_logout_success(): void
    {
        $this->seed(CreateUserSeeder::class);
        $user = User::first();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $this->assertNull(auth()->user());
    }
}
