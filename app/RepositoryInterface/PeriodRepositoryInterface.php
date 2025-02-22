<?php

namespace App\RepositoryInterface;

use App\Models\Period;

interface PeriodRepositoryInterface
{
    public function create(int $userId, int $month, int $year): ?Period;

    public function findOrCreate(int $userId, int $month, int $year): ?Period;
}
