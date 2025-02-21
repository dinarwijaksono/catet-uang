<?php

namespace App\Repository;

use App\Domain\TransactionDomain;
use App\Models\Transaction;
use App\RepositoryInterface\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function create(TransactionDomain $transaction): ?Transaction
    {
        return Transaction::create([
            'user_id' => $transaction->userId,
            'period_id' => $transaction->periodId,
            'category_id' => $transaction->categoryId,
            'code' => $transaction->code,
            'date' => $transaction->date,
            'description' => $transaction->description,
            'income' => $transaction->income,
            'spending' => $transaction->spending
        ]);
    }
}
