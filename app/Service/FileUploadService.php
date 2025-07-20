<?php

namespace App\Service;

use App\Models\FileUpload;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
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

    public function getAll(int $userId): Collection
    {
        try {

            $file = FileUpload::where('user_id', $userId)->get();

            Log::info('get all file upload success', [
                'user_id' => $userId
            ]);

            return $file;
        } catch (\Throwable $th) {

            Log::error('get all file upload failed', [
                'user_id' => $userId,
                'message' => $th->getMessage()
            ]);

            return collect();
        }
    }

    public function update(int $userId, string $fileName, string $message): void
    {
        try {
            FileUpload::where('user_id', $userId)
                ->where('file_name', $fileName)
                ->update([
                    'is_generate' => true,
                    'message' => $message,
                    'updated_at' => Carbon::now()
                ]);

            Log::info('generate success', [
                'user_id' => $userId,
                'file_name' => $fileName,
            ]);
        } catch (\Throwable $th) {
            Log::error('generate failed', [
                'user_id' => $userId,
                'file_name' => $fileName,
                'message' => $th->getMessage()
            ]);
        }
    }
}
