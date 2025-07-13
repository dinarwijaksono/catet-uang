<?php

namespace Tests\Feature\Service;

use App\Models\ApiToken;
use App\Models\User;
use App\Service\UserService;
use Database\Seeders\CreateUserSeeder;
use Database\Seeders\CreateUserWithTokenSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use stdClass;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    protected $userService;

    public function setUp(): void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserService::class);
    }

    public function test_register_success()
    {
        $name = 'test';
        $email = 'test@gmail.com';
        $password = 'rahasia';

        $response = $this->userService->register($name, $email, $password);

        $this->assertInstanceOf(User::class, $response);
        $this->assertEquals($response->name, $name);
        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email
        ]);

        $this->assertEquals(auth()->user()->name, $name);
        $this->assertEquals(auth()->user()->email, $email);
    }

    public function test_register_but_the_email_is_already_there()
    {
        $this->seed(CreateUserSeeder::class);
        $user = User::first();

        $response = $this->userService->register('coba', $user->email, "rahasia1234");

        $this->assertNull($response);
        $this->assertDatabaseCount('users', 1);
        $this->assertNull(auth()->user());
    }

    public function test_login_success()
    {
        $this->seed(CreateUserSeeder::class);
        $user = User::first();

        $response = $this->userService->login($user->email, 'rahasia1234');

        $this->assertInstanceOf(User::class, $response);
    }

    public function test_login_but_password_is_wrong()
    {
        $this->seed(CreateUserSeeder::class);
        $user = User::first();

        $response = $this->userService->login($user->email, 'password-salah');

        $this->assertNull($response);
    }

    public function test_login_but_email_is_wrong()
    {
        $response = $this->userService->login('example@gmail.com', 'password-salah');

        $this->assertNull($response);
    }

    public function test_find_by_token_success()
    {
        $this->seed(CreateUserWithTokenSeeder::class);
        $api = ApiToken::first();

        $user = $this->userService->findByToken($api->token);

        $this->assertInstanceOf(stdClass::class, $user);
    }

    public function test_find_by_token_return_null()
    {
        $user = $this->userService->findByToken('token-tidak-ada');

        $this->assertNull($user);
    }


    public function test_find_by_email_but_return_null()
    {
        $response = $this->userService->findByEmail('emailIsEmpty@gmail.com');

        $this->assertNull($response);
    }

    public function test_find_by_email_success()
    {
        $this->seed(CreateUserSeeder::class);
        $user = User::first();

        $response = $this->userService->findByEmail($user->email);

        $this->assertInstanceOf(User::class, $response);
    }

    public function test_logout_success()
    {
        $this->seed(CreateUserWithTokenSeeder::class);
        $user = ApiToken::first();

        $this->assertDatabaseHas('api_tokens', [
            'token' => $user->token
        ]);

        $this->userService->logout($user->token);

        $this->assertDatabaseMissing('api_tokens', [
            'token' => $user->token
        ]);
    }
}
