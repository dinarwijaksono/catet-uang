<?php

namespace App\Repository;

use App\Domain\TransactionDomain;
use App\Models\Transaction;
use App\RepositoryInterface\TransactionRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use stdClass;
use Termwind\Components\Raw;

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

    public function findByCode(int $userId, string $code): ?Transaction
    {
        return Transaction::where('user_id', $userId)
            ->where('code', $code)
            ->first();
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

    public function getSummaryTotalIncomeSpendingAll(int $userId): ?stdClass
    {
        return DB::table('transactions')
            ->select(DB::raw('sum(income) as total_income'), DB::raw('sum(spending) as total_spending'))
            ->where('user_id', $userId)
            ->first();
    }

    public function getSummaryTotalIncomeSpendingByPeriod(int $userId, int $periodId): ?stdClass
    {
        return DB::table('transactions')
            ->select(DB::raw('sum(income) as total_income'), DB::raw('sum(spending) as total_spending'))
            ->where('user_id', $userId)
            ->where('period_id', $periodId)
            ->first();
    }

    public function getSummaryIncomeSpending(int $userId): ?Collection
    {
        return DB::table('transactions')
            ->select('date', DB::raw("sum(income) as total_income"), DB::raw('sum(spending) as total_spending'))
            ->where("user_id", $userId)
            ->groupBy('date')
            ->orderByDesc('date')
            ->limit(40)
            ->get()
            ->map(function ($row) {
                $row->total_income = (integer) $row->total_income;
                $row->total_spending = (integer) $row->total_spending;
                return $row;
            });
    }

    public function getTotalCategoryAllByPeriod(int $userId, int $periodId): ?Collection
    {
        return DB::table('transactions')
            ->join('categories', 'categories.id', '=', 'transactions.category_id')
            ->select(
                'transactions.category_id',
                'categories.name as category_name',
                DB::raw('sum(transactions.income) as total_income'),
                DB::raw('sum(transactions.spending) as total_spending')
            )
            ->where('transactions.user_id', $userId)
            ->where('transactions.period_id', $periodId)
            ->groupBy(
                'transactions.category_id',
                'categories.name',
                'transactions.period_id'
            )
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

    public function getTransactionByPeriod(int $userId, int $periodId): ?Collection
    {
        return DB::table('transactions')
            ->join('categories', 'categories.id', '=', 'transactions.category_id')
            ->select(
                'categories.id as category_id',
                'categories.name as category_name',
                'transactions.code',
                'transactions.date',
                'transactions.description',
                'transactions.income',
                'transactions.spending',
                'transactions.created_at',
                'transactions.updated_at'
            )
            ->where('transactions.user_id', $userId)
            ->where('transactions.period_id', $periodId)
            ->get();
    }

    public function delete(int $userId, string $code): void
    {
        Transaction::where('user_id', $userId)
            ->where('code', $code)
            ->delete();
    }
}
