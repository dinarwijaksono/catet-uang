<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Period;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $category = Category::first();

        $date = strtotime("2024-01-01");

        $period = Period::create([
            'user_id' => $user->id,
            'period_date' => $date,
            'period_name' => date("F Y", strtotime("2024-01-01")),
            'is_close' => false
        ]);

        $d = Carbon::createFromFormat('Y-m-d', "2024-01-01")->setTime(0, 0, 0, 0);

        Transaction::create([
            'user_id' => $user->id,
            'period_id' => $period->id,
            'category_id' => $category->id,
            'code' => Str::random(10),
            'date' => $d,
            'description' => 'test' . random_int(1, 100),
            'income' => $category->type == 'income' ? 10000 : 0,
            'spending' => $category->type == 'spending' ? 10000 : 0
        ]);
    }
}
