<?php

namespace App\Service;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileFormatService
{
    public function createFileImport(): void
    {
        try {
            $content = "NO,TANGGAL,BULAN,TAHUN,TYPE,KATEGORI,DESKRIPSI,NILAI";

            Storage::disk('public-custom')->put('format_import/file_format_for_import.csv', $content);

            Log::info('create format file for import success');
        } catch (\Throwable $th) {
            Log::error('create format file for import failed', [
                'message' => $th->getMessage()
            ]);
        }
    }
}
