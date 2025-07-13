<?php

namespace App\RepositoryInterface;

use App\Domain\TransactionDomain;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use stdClass;

interface TransactionRepositoryInterface
{
    public function create(TransactionDomain $transaction): ?Transaction;

    public function findByCode(int $userId, string $code): ?Transaction;

    public function getByDate(int $userId, Carbon $date): ?Collection;

    public function getSummaryTotalIncomeSpendingAll(int $userId): ?stdClass;

    public function getSummaryTotalIncomeSpendingByPeriod(int $userId, int $periodId): ?stdClass;

    public function getSummaryIncomeSpending(int $userId): ?Collection;

    public function getTotalCategoryAllByPeriod(int $userId, int $periodId): ?Collection;

    public function getTransactionByPeriod(int $userId, int $periodId): ?Collection;

    public function update(TransactionDomain $transaction): ?Transaction;

    public function delete(int $userId, string $code): void;
}
