<?php

namespace Database\Seeders;

use App\Models\ApiToken;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CreateUserWithTokenSeeder::class,
            CreateCategorySeeder::class,
            CreateTransactionIncomeSeeder::class,
            CreateTransactionSpendigSeeder::class,
            CreateTransactionSpendigSeeder::class,
        ]);
    }
}
