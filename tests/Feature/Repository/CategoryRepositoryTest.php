<?php

namespace Tests\Feature\Repository;

use App\Models\Category;
use App\Models\User;
use App\RepositoryInterface\CategoryRepositoryInterface;
use Carbon\Carbon;
use Database\Seeders\CreateCategorySeeder;
use Database\Seeders\CreateTransactionSeeder;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Database\Eloquent\Collection;
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

    public function test_check_is_still_use_return_true()
    {
        $this->seed(CreateCategorySeeder::class);
        $this->seed(CreateTransactionSeeder::class);

        $category = Category::first();

        $response = $this->categoryRepository->checkIsStillUse($this->user->id, $category->id);

        $this->assertTrue($response);
    }

    public function test_check_is_still_use_return_false()
    {
        $this->seed(CreateCategorySeeder::class);

        $category = Category::first();

        $response = $this->categoryRepository->checkIsStillUse($this->user->id, $category->id);

        $this->assertFalse($response);
    }

    public function test_find_by_code_success()
    {
        $this->seed(CreateCategorySeeder::class);
        $category = Category::first();

        $response = $this->categoryRepository->findByCode($this->user->id, $category->code);

        $this->assertInstanceOf(Category::class, $response);
    }

    public function test_find_by_name_but_category_noting_in_db()
    {
        $response = $this->categoryRepository->findByName($this->user->id, 'category-nothing', 'spending');

        $this->assertNull($response);
    }

    public function test_find_by_name_success()
    {
        $this->seed(CreateCategorySeeder::class);
        $category = Category::first();

        $response = $this->categoryRepository->findByName($this->user->id, $category->name, 'income');

        $this->assertInstanceOf(Category::class, $response);
    }

    public function test_find_by_code_return_null()
    {
        $response = $this->categoryRepository->findByCode($this->user->id, 'categorynull');

        $this->assertNull($response);
    }

    public function test_get_all_success()
    {
        $this->seed(CreateCategorySeeder::class);
        $this->seed(CreateCategorySeeder::class);
        $this->seed(CreateCategorySeeder::class);

        $response = $this->categoryRepository->getAll($this->user->id);

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals($response->count(), 6);
    }

    public function test_get_all_return_null()
    {
        $response = $this->categoryRepository->getAll($this->user->id);

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals($response->count(), 0);
    }

    public function test_update_success()
    {
        $this->seed(CreateCategorySeeder::class);

        $category = Category::first();

        $response = $this->categoryRepository->update($this->user->id, $category->code, 'test-001');

        $this->assertInstanceOf(Category::class, $response);
        $this->assertEquals($response->name, 'test-001');
    }

    public function test_delete_success()
    {
        $this->seed(CreateCategorySeeder::class);
        $category = Category::first();

        $this->categoryRepository->delete($this->user->id, $category->code);

        $this->assertDatabaseMissing('categories', [
            'code' => $category->code
        ]);
    }
}
