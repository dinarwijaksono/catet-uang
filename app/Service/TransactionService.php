<?php

namespace App\Service;

use App\Domain\TransactionDomain;
use App\Models\Transaction;
use App\RepositoryInterface\PeriodRepositoryInterface;
use App\RepositoryInterface\TransactionRepositoryInterface;
use Carbon\Carbon;
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

            $dateCarbon = Carbon::createFromFormat('Y/m/d', $date);

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
}
