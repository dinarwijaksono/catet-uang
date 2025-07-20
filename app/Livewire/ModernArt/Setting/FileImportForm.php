<?php

namespace App\Livewire\ModernArt\Setting;

use App\Service\FileFormatService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class FileImportForm extends Component
{
    protected $fileFormatService;

    public function boot()
    {
        $this->fileFormatService = app()->make(FileFormatService::class);
    }

    public function doDownload()
    {
        $path = 'format_import/file_format_for_import.csv';

        if (!Storage::disk('public-custom')->exists($path)) {

            $this->fileFormatService->createFileImport();
        }

        return Storage::disk('public-custom')->download($path, 'format file ' . date('d-m-Y') . '.csv');
    }

    public function render()
    {
        return view('livewire.modern-art.setting.file-import-form');
    }
}
