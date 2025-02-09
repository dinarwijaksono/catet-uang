<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CreateCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        Category::create([
            'user_id' => $user->id,
            'code' => Str::random(10),
            'name' => 'test - ' . random_int(1, 100),
            'type' => 'income',
        ]);

        Category::create([
            'user_id' => $user->id,
            'code' => Str::random(10),
            'name' => 'test - ' . random_int(1, 100),
            'type' => 'spending',
        ]);
    }
}
