<?php

namespace Tests\Feature\Livewire\ModernArt\Setting;

use App\Livewire\ModernArt\Setting\FileImportForm;
use App\Models\User;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class FileImportFormTest extends TestCase
{
    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(CreateUserSeeder::class);
        $this->user = User::first();
        $this->actingAs($this->user);
    }

    public function test_renders_successfully()
    {
        Livewire::test(FileImportForm::class)
            ->assertStatus(200);
    }
}
