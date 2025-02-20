<?php

namespace App\Repository;

use App\Models\Period;
use App\RepositoryInterface\PeriodRepositoryInterface;

class PeriodRepository implements PeriodRepositoryInterface
{
    public function create(int $userId, int $month, int $year): ?Period
    {
        $date = strtotime("$year-$month-01");

        return Period::create([
            'user_id' => $userId,
            'period_date' => $date,
            'period_name' => date("F Y", $date),
            'is_close' => false
        ]);
    }
}
