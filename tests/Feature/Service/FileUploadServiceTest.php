<?php

namespace Tests\Feature\Service;

use App\Models\FileUpload;
use App\Models\User;
use App\Service\FileUploadService;
use Database\Seeders\CreateUserSeeder;
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
}
