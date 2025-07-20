<?php

namespace Tests\Feature\Service;

use App\Models\FileUpload;
use App\Models\User;
use App\Service\FileUploadService;
use Database\Seeders\CreateFileUploadSeeder;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FileUploadServiceTest extends TestCase
{
    public $user;

    protected $fileUploadService;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserSeeder::class);
        $this->user = User::first();
        $this->actingAs($this->user);

        $this->fileUploadService = app()->make(FileUploadService::class);
    }

    public function test_create_success(): void
    {
        $response = $this->fileUploadService->create($this->user->id, 'test.csv');

        $this->assertInstanceOf(FileUpload::class, $response);
        $this->assertDatabaseHas('file_uploads', [
            'user_id' => $this->user->id,
            'file_name' => $response->file_name,
            'original_name' => 'test.csv',
            'is_generate' => false,
            'message' => 'Belum digenerate'
        ]);
    }

    public function test_get_all()
    {
        $this->seed(CreateFileUploadSeeder::class);
        $this->seed(CreateFileUploadSeeder::class);
        $this->seed(CreateFileUploadSeeder::class);

        $response = $this->fileUploadService->getAll($this->user->id);

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals(3, $response->count());
    }

    public function test_update_success()
    {
        $this->seed(CreateFileUploadSeeder::class);

        $data = FileUpload::first();

        $this->fileUploadService->update($this->user->id, $data->file_name, 'data kurang');

        $this->assertDatabaseHas('file_uploads', [
            'user_id' => $this->user->id,
            'file_name' => $data->file_name,
            'message' => 'data kurang',
            'is_generate' => true
        ]);
    }
}
