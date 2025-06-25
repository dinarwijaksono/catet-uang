<?php

namespace App\RepositoryInterface;

use App\Models\Period;
use Illuminate\Support\Collection;

interface PeriodRepositoryInterface
{
    public function create(int $userId, int $month, int $year): ?Period;

    public function findOrCreate(int $userId, int $month, int $year): ?Period;

    public function getAll(int $userId): ?Collection;
}
