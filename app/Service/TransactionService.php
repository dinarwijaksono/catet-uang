<?php

namespace App\Service;

use App\Domain\TransactionDomain;
use App\Models\Transaction;
use App\RepositoryInterface\PeriodRepositoryInterface;
use App\RepositoryInterface\TransactionRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionService
{
    protected $periodRepository;
    protected $transactionRepository;

    public function __construct(PeriodRepositoryInterface $periodRepository, TransactionRepositoryInterface $transactionRepository)
    {
        $this->periodRepository = $periodRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function create(int $userId, int $categoryId, string $date, string $description, int $income, int $spending): ?Transaction
    {
        try {
            DB::beginTransaction();

            $dateCarbon = Carbon::createFromFormat('Y-m-d', $date)->setTime(0, 0, 0, 0);

            $start = microtime(true);
            $period = $this->periodRepository->findOrCreate($userId, $dateCarbon->month, $dateCarbon->year);

            $executionTime = round((microtime(true) - $start) * 1000);
            if ($executionTime > 2000) {
                Log::warning("Execution of PeriodRepository->findOrCreate is slow", [
                    'user_id' => $userId,
                    'execution_time' => $executionTime,
                ]);
            }

            $insert = new TransactionDomain();
            $insert->userId = $userId;
            $insert->periodId = $period->id;
            $insert->categoryId = $categoryId;
            $insert->code = Str::random(10);
            $insert->date = $dateCarbon;
            $insert->description = $description;
            $insert->income = $income;
            $insert->spending = $spending;

            $start = microtime(true);
            $result = $this->transactionRepository->create($insert);

            $executionTime = round((microtime(true) - $start) * 1000);
            if ($executionTime > 2000) {
                Log::warning("Execution of TransactionRepository->create is slow", [
                    'user_id' => $userId,
                    'execution_time' => $executionTime
                ]);
            }

            DB::commit();

            Log::info('create transaction success', [
                'user_id' => $userId,
                'data' => [
                    'category_id' => $categoryId,
                    'date' => $date,
                    'description' => $description,
                    'income' => $income,
                    'spending' => $spending
                ]
            ]);

            return $result;
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('create transaction failed', [
                'message' => $th->getMessage(),
                'user_id' => $userId,
                'data' => [
                    'category_id' => $categoryId,
                    'date' => $date,
                    'description' => $description,
                    'income' => $income,
                    'spending' => $spending
                ]
            ]);

            return null;
        }
    }

    public function findByCode(int $userId, string $code): ?Transaction
    {
        try {
            $start = microtime(true);
            $transaction = $this->transactionRepository->findByCode($userId, $code);

            $executionTime = round((microtime(true) - $start) * 1000);
            if ($executionTime > 2000) {
                Log::warning("Execution of transactionRepository->findByCode is slow", [
                    'user_id' => $userId,
                    'execution_time' => $executionTime,
                ]);
            }

            Log::info('find by code transaction success', [
                'user_id' => $userId,
                'code' => $code
            ]);

            return $transaction;
        } catch (\Throwable $th) {
            Log::error('find by code transaction failed', [
                'user_id' => $userId,
                'code' => $code,
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }

    public function getByDate(int $userId, Carbon $date): ?Collection
    {
        try {
            $start = microtime(true);
            $transaction = $this->transactionRepository->getByDate($userId, $date->setTime(0, 0, 0, 0));

            $executionTime = round((microtime(true) - $start) * 1000);
            if ($executionTime > 2000) {
                Log::warning("Execution of transactionRepository->getByDate is slow", [
                    'user_id' => $userId,
                    'execution_time' => $executionTime,
                ]);
            }

            Log::info('get by date transaction success', [
                'user_id' => $userId
            ]);

            return $transaction;
        } catch (\Throwable $th) {
            Log::error('get by date transaction failed', [
                'user_id' => $userId,
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }

    public function getSummaryIncomeSpending(int $userId): ?Collection
    {
        try {

            $start = microtime(true);
            $result = $this->transactionRepository->getSummaryIncomeSpending($userId);

            $executionTime = round((microtime(true) - $start) * 1000);
            if ($executionTime > 2000) {
                Log::warning("Execution of transactionRepository->getSummaryIncomeSpending is slow", [
                    'user_id' => $userId,
                    'execution_time' => $executionTime,
                ]);
            }

            Log::info('get summary income spending success', [
                'user_id' => $userId
            ]);

            return $result;
        } catch (\Throwable $th) {
            Log::error('get summary income spending failed', [
                'user_id' => $userId,
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }

    public function update(int $userId, string $code, int $categoryId, string $date, string $description, int $income, int $spending): ?Transaction
    {
        try {
            DB::beginTransaction();

            $dateCarbon = Carbon::createFromFormat('Y-m-d', $date)->setTime(0, 0, 0, 0);

            $period = $this->periodRepository->findOrCreate($userId, $dateCarbon->month, $dateCarbon->year);

            $update = new TransactionDomain();
            $update->userId = $userId;
            $update->code = $code;
            $update->periodId = $period->id;
            $update->categoryId = $categoryId;
            $update->date = $dateCarbon;
            $update->description = $description;
            $update->income = $income;
            $update->spending = $spending;

            $start = microtime(true);
            $transaction = $this->transactionRepository->update($update);

            $executionTime = round((microtime(true) - $start) * 1000);
            if ($executionTime > 2000) {
                Log::warning("Execution of transactionRepository->update is slow", [
                    'user_id' => $userId,
                    'execution_time' => $executionTime,
                ]);
            }

            DB::commit();

            Log::info('update transacrion success', [
                'user_id' => $userId,
                'data' => [
                    'category_id' => $categoryId,
                    'date' => $date,
                    'description' => $description,
                    'income' => $income,
                    'spending' => $spending
                ],
            ]);

            return $transaction;
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('update transaction failed', [
                'user_id' => $userId,
                'data' => [
                    'category_id' => $categoryId,
                    'date' => $date,
                    'description' => $description,
                    'income' => $income,
                    'spending' => $spending
                ],
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }

    public function delete(int $userId, string $code): void
    {
        try {
            $start = microtime(true);
            $this->transactionRepository->delete($userId, $code);
            $executionTime = round((microtime(true) - $start) * 1000);
            if ($executionTime > 2000) {
                Log::warning("Execution of transactionRepository->delete is slow", [
                    'user_id' => $userId,
                    'execution_time' => $executionTime,
                ]);
            }

            Log::info('delete transaction success', [
                'user_id' => $userId,
                'code' => $code
            ]);
        } catch (\Throwable $th) {
            Log::error('delete transaction failed', [
                'user_id' => $userId,
                'code' => $code,
                'message' => $th->getMessage()
            ]);
        }
    }
}
