<?php

namespace Database\Seeders;

use App\Models\ApiToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUserWithTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('rahasia1234')
        ]);

        ApiToken::create([
            'user_id' => $user->id,
            'token' => Str::random(32),
            'expired_at' => Carbon::now()->addDays(3)
        ]);
    }
}
