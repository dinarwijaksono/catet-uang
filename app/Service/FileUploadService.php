<?php

namespace App\Service;

use App\Models\FileUpload;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FileUploadService
{
    public function create(int $userId, string $originalFileName): ?FileUpload
    {
        try {
            $file = FileUpload::create([
                'user_id' => $userId,
                'original_name' => $originalFileName,
                'file_name' => Str::random(15) . '.csv',
                'is_generate' => false,
                'message' => 'Belum digenerate'
            ]);

            Log::info('create file upload success', [
                'user_id' => $userId,
                'file_name' => $file->file_name
            ]);

            return $file;
        } catch (\Throwable $th) {
            Log::error('create file upload failed', [
                'user_id' => $userId,
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }
}
