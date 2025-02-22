<?php

namespace App\RepositoryInterface;

use App\Domain\TransactionDomain;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Collection;

interface TransactionRepositoryInterface
{
    public function create(TransactionDomain $transaction): ?Transaction;

    public function getByDate(int $userId, Carbon $date): ?Collection;
}
