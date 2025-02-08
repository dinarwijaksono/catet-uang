<?php

namespace Tests\Feature\Service;

use App\Service\UserService;
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
}
