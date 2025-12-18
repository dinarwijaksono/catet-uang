<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\FileFormatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileFormatControllerApi extends Controller
{
    protected FileFormatService $fileFormatService;

    public function __construct(FileFormatService $fileFormatService)
    {
        $this->fileFormatService = $fileFormatService;
    }

    public function downloadCsv()
    {
        $this->fileFormatService->createFileImport();

        $filePath = Storage::disk('public-custom')->path('format_import/file_format_for_import.csv');

        return response()->download($filePath, 'file format.csv', [
            'Content-Type' => 'text/csv'
        ]);
    }
}
