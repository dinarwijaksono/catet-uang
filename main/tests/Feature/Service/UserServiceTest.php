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

    public function test_login_for_api_success()
    {
        $this->seed(CreateUserSeeder::class);
        $user = User::first();

        $response = $this->userService->loginForApi($user->email, 'rahasia1234');

        $this->assertInstanceOf(stdClass::class, $response);
        $this->assertObjectHasProperty('token', $response);
        $this->assertObjectHasProperty('name', $response);
    }

    public function test_login_for_api_return_null_because_password_is_wrong()
    {
        $this->seed(CreateUserSeeder::class);
        $user = User::first();

        $response = $this->userService->loginForApi($user->email, 'rahasia');

        $this->assertNull($response);
    }

    public function test_login_success()
    {
        $this->seed(CreateUserSeeder::class);
        $user = User::first();

        $response = $this->userService->login($user->email, 'rahasia1234');

        $this->assertInstanceOf(User::class, $response);
        $this->assertEquals(auth()->user()->email, $user->email);
        $this->assertEquals(auth()->user()->name, $user->name);
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
}
