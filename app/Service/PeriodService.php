<?php

namespace App\Service;

use App\Models\Period;
use Illuminate\Support\Collection;

class PeriodService
{
    public function getAll(int $userId): Collection
    {
        return Period::where('user_id', $userId)->get();
    }
}
