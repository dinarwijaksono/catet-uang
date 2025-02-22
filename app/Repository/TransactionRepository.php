<?php

namespace App\Repository;

use App\Domain\TransactionDomain;
use App\Models\Transaction;
use App\RepositoryInterface\TransactionRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    public function getByDate(int $userId, Carbon $date): ?Collection
    {
        return DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.user_id')
            ->join('categories', 'categories.id', '=', 'transactions.category_id')
            ->join('periods', 'periods.id', '=', 'transactions.period_id')
            ->select(
                'categories.id as category_id',
                'categories.name as category_name',
                'periods.period_date',
                'periods.period_name',
                'transactions.code',
                'transactions.date',
                'transactions.description',
                'transactions.income',
                'transactions.spending',
                'transactions.created_at',
                'transactions.updated_at'
            )
            ->where('transactions.user_id', $userId)
            ->where('transactions.date', $date)
            ->get();
    }

    public function update(TransactionDomain $transaction): ?Transaction
    {
        Transaction::where('code', $transaction->code)
            ->update([
                'period_id' => $transaction->periodId,
                'category_id' => $transaction->categoryId,
                'date' => $transaction->date,
                'description' => $transaction->description,
                'income' => $transaction->income,
                'spending' => $transaction->spending,
                'updated_at' => Carbon::now()
            ]);

        return Transaction::where('code', $transaction->code)->first();
    }

    public function delete(int $userId, string $code): void
    {
        Transaction::where('user_id', $userId)
            ->where('code', $code)
            ->delete();
    }
}
