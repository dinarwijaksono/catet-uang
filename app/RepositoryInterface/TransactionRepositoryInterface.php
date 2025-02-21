<?php

namespace App\RepositoryInterface;

use App\Domain\TransactionDomain;
use App\Models\Transaction;

interface TransactionRepositoryInterface
{
    public function create(TransactionDomain $transaction): ?Transaction;
}
