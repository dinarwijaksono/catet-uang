<?php

namespace Tests\Feature\Repository;

use App\Models\Category;
use App\Models\User;
use App\RepositoryInterface\CategoryRepositoryInterface;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class CategoryRepositoryTest extends TestCase
{
    protected $user;
    protected $categoryRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserSeeder::class);
        $this->user = User::first();

        $this->categoryRepository = $this->app->make(CategoryRepositoryInterface::class);
    }

    public function test_create_success_data_income(): void
    {
        $code = Str::random(10);
        $name = 'test';
        $type = 'income';

        $response = $this->categoryRepository->create($this->user->id, $code, $name, $type);

        $this->assertInstanceOf(Category::class, $response);
        $this->assertEquals($response->code, $code);
        $this->assertEquals($response->name, $name);
        $this->assertEquals($response->type, $type);
        $this->assertDatabaseHas('categories', [
            'user_id' => $this->user->id,
            'code' => $code,
            'name' => $name,
            'type' => $type,
        ]);
    }

    public function test_create_success_data_spending(): void
    {
        $code = Str::random(10);
        $name = 'test11';
        $type = 'spending';

        $response = $this->categoryRepository->create($this->user->id, $code, $name, $type);

        $this->assertInstanceOf(Category::class, $response);
        $this->assertEquals($response->code, $code);
        $this->assertEquals($response->name, $name);
        $this->assertEquals($response->type, $type);
        $this->assertDatabaseHas('categories', [
            'user_id' => $this->user->id,
            'code' => $code,
            'name' => $name,
            'type' => $type,
        ]);
    }
}
