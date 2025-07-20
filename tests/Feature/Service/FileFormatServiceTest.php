<?php

namespace Tests\Feature\Service;

use App\Service\FileFormatService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileFormatServiceTest extends TestCase
{
    protected $fileFormatService;

    public function setUp(): void
    {
        parent::setUp();

        $this->fileFormatService = app()->make(FileFormatService::class);
    }

    public function test_create_file_import_success(): void
    {
        $this->fileFormatService->createFileImport();

        $this->assertTrue(Storage::disk('public-custom')->exists('format_import/file_format_for_import.csv'));
    }
}
