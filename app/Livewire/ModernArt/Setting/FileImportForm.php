<?php

namespace App\Livewire\ModernArt\Setting;

use App\Service\FileFormatService;
use App\Service\FileUploadService;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Component;

class FileImportForm extends Component
{
    use WithFileUploads;

    protected $fileFormatService;
    protected $fileUploadService;

    public $file;

    public $files;

    public function boot()
    {
        $this->fileFormatService = app()->make(FileFormatService::class);
        $this->fileUploadService = app()->make(FileUploadService::class);

        $this->files = $this->fileUploadService->getAll(auth()->user()->id)->sortByDesc('created_at');
    }

    public function getListeners()
    {
        return [
            'do-refresh' => 'boot'
        ];
    }

    public function doDownload()
    {
        $path = 'format_import/file_format_for_import.csv';

        if (!Storage::disk('public-custom')->exists($path)) {

            $this->fileFormatService->createFileImport();
        }

        return Storage::disk('public-custom')->download($path, 'format file ' . date('d-m-Y') . '.csv');
    }

    public function getRules()
    {
        return [
            'file' => 'required|extensions:csv|max:3072'
        ];
    }

    public function doUpload()
    {
        $this->validate();

        $originalName = $this->file->getClientOriginalName();

        $upload = $this->fileUploadService->create(auth()->user()->id, $originalName);

        $this->file->storeAs('file_for_import', $upload->file_name, 'public-custom');

        $this->dispatch('show-alert-upload-success');
        $this->dispatch('do-refresh');

        $this->file = '';
    }

    public function doGenerate(string $fileName)
    {
        if (!Storage::disk('public-custom')->exists('file_for_import/' . $fileName)) {
            $this->fileUploadService->update(auth()->user()->id, $fileName, "File rusak.");
            $this->dispatch('do-refresh');

            return;
        }

        $data = $this->fileUploadService->parseCsvToArray(Storage::disk('public-custom')->get('file_for_import/' . $fileName));

        if (!empty($data['errors'])) {
            $this->fileUploadService->update(auth()->user()->id, $fileName, $data['errors'][0]);
            $this->dispatch('do-refresh');

            return;
        }

        return dd($data['result']);
    }

    public function render()
    {
        return view('livewire.modern-art.setting.file-import-form');
    }
}
