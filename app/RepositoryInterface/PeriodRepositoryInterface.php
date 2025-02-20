<?php

namespace App\RepositoryInterface;

use App\Models\Period;

interface PeriodRepositoryInterface
{
    public function create(int $userId, int $month, int $year): ?Period;
}
