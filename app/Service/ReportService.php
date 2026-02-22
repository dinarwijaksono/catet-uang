<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;
use stdClass;

class ReportService
{
    public function getTotalIncomeSpending(int $userId): ?stdClass
    {
        return DB::table('transactions')
            ->select(DB::raw('sum(income) as total_income'), DB::raw('sum(spending) as total_spending'))
            ->where('user_id', $userId)
            ->get()
            ->map(function ($row) {
                $row->total_income = (int) $row->total_income;
                $row->total_spending = (int) $row->total_spending;

                return $row;
            })
            ->first();
    }
}
