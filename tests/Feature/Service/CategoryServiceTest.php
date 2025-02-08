<?php

namespace Tests\Feature\Service;

use App\Models\Category;
use App\Models\User;
use App\Service\CategoryService;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    protected $user;
    protected $categoryService;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserSeeder::class);
        $this->user = User::first();

        $this->categoryService = $this->app->make(CategoryService::class);
    }

    public function test_create_success_with_type_income(): void
    {
        $name = 'Gaji';
        $type = 'income';

        $response = $this->categoryService->create($this->user->id, $name, $type);
        $this->assertInstanceOf(Category::class, $response);
        $this->assertEquals($response->name, strtolower($name));
        $this->assertEquals($response->type, $type);
    }

    public function test_create_success_with_type_spending(): void
    {
        $name = 'Makanan';
        $type = 'spending';

        $response = $this->categoryService->create($this->user->id, $name, $type);
        $this->assertInstanceOf(Category::class, $response);
        $this->assertEquals($response->name, strtolower($name));
        $this->assertEquals($response->type, $type);
    }

    public function test_create_return_null(): void
    {
        $name = 'Makanan';
        $type = 'spendingss';

        $response = $this->categoryService->create($this->user->id, $name, $type);
        $this->assertNull($response);
    }
}
