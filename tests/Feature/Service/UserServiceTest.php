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

    public function test_register_for_api_success(): void
    {
        $name = 'test';
        $email = 'test@gmail.com';
        $password = 'rahasia';

        $response = $this->userService->registerForApi($name, $email, $password);

        $this->assertInstanceOf(stdClass::class, $response);
        $this->assertEquals($name, $response->name);
        $this->assertEquals($email, $response->email);
        $this->assertObjectHasProperty('token', $response);
        $this->assertObjectHasProperty('expired_at', $response);
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
