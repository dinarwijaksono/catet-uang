<?php

namespace App\Domain;

use Carbon\Carbon;

class TransactionDomain
{
    public int $userId;
    public ?int $periodId;
    public ?int $categoryId;
    public ?string $code;
    public ?Carbon $date;
    public ?string $description;
    public ?int $income;
    public ?int $spending;
}
