<?php

namespace Tests\Feature\Repository;

use App\Models\User;
use App\RepositoryInterface\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    public $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->app->make(UserRepositoryInterface::class);
    }

    public function test_create_success(): void
    {
        $name = 'test';
        $email = 'test@gmail.com';
        $password = 'rahasia';

        $response = $this->userRepository->create($name, $email, $password);

        $this->assertInstanceOf(User::class, $response);
        $this->assertEquals($response->name, $name);
        $this->assertEquals($response->email, $email);

        $this->assertTrue(Hash::check($password, $response->password));
    }
}
