<?php

namespace Database\Seeders;

use App\Models\FileUpload;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CreateFileUploadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        FileUpload::create([
            'user_id' => $user->id,
            'file_name' => Str::random(15) . '.csv',
            'original_name' => 'test.csv',
            'is_generate' => false,
            'message' => 'Belum digenerate'
        ]);
    }
}
