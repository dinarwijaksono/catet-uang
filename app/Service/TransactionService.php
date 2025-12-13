<?php

namespace App\Service;

use App\Domain\TransactionDomain;
use App\Models\Category;
use App\Models\Transaction;
use App\Repository\CategoryRepository;
use App\RepositoryInterface\PeriodRepositoryInterface;
use App\RepositoryInterface\TransactionRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;

class TransactionService
{
    protected $categoryRepository;
    protected $periodRepository;
    protected $transactionRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        PeriodRepositoryInterface $periodRepository,
        TransactionRepositoryInterface $transactionRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->periodRepository = $periodRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function create(int $userId, string $categoryId, string $date, string $description, int $income, int $spending): ?Transaction
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

    public function createFromArray(int $userId, array $data): void
    {
        try {
            DB::beginTransaction();

            foreach ($data as $key) {
                $category = $this->categoryRepository->findByName($userId, $key['category'], $key['type']);

                if (is_null($category)) {
                    $code = Str::random(10);
                    $category = $this->categoryRepository->create($userId, $code, $key['category'], $key['type']);
                }

                $in = $key['type'] == 'income' ? $key['value'] : 0;
                $out = $key['type'] == 'spending' ? $key['value'] : 0;

                self::create($userId, $category->id, $key['date'], $key['description'], $in, $out);
            }


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('create from array failed', [
                'user_id' => $userId,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function amountTransaction(int $userId): int
    {
        try {
            $amount = Transaction::where('user_id', $userId)->count();

            Log::info('count transaction success', [
                'user_id' => $userId
            ]);

            return $amount;
        } catch (\Throwable $th) {
            Log::error('count transaction failed', [
                'user_id' => $userId,
                'message' => $th->getMessage()
            ]);

            return 0;
        }
    }

    public function getAllPeriod(int $userId): ?Collection
    {
        try {
            $start = microtime(true);
            $period = $this->periodRepository->getAll($userId);

            $executionTime = round((microtime(true) - $start) * 1000);
            if ($executionTime > 2000) {
                Log::warning("Execution of PeriodRepository->getAll is slow", [
                    'user_id' => $userId,
                    'execution_time' => $executionTime,
                ]);
            }

            Log::info('get all period success', [
                'user_id' => $userId
            ]);

            return $period;
        } catch (\Throwable $th) {

            Log::error('get all period success', [
                'user_id' => $userId,
                'message' => $th->getMessage()
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

    public function getSummaryTotalIncomeSpendingAll(int $userId): ?stdClass
    {
        try {
            $start = microtime(true);
            $result = $this->transactionRepository->getSummaryTotalIncomeSpendingAll($userId);

            $executionTime = round((microtime(true) - $start) * 1000);
            if ($executionTime > 2000) {
                Log::warning("Execution of transactionRepository->getSummaryTotalIncomeSpendingAll is slow", [
                    'user_id' => $userId,
                    'execution_time' => $executionTime,
                ]);
            }

            Log::info('get summary total income spending all success', [
                'user_id' => $userId
            ]);

            return $result;
        } catch (\Throwable $th) {
            Log::error('get summary total income spending all failed', [
                'user_id' => $userId,
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }

    public function getSummaryTotalIncomeSpendingByPeriod(int $userId, int $periodId): ?stdClass
    {
        try {
            $start = microtime(true);
            $result = $this->transactionRepository->getSummaryTotalIncomeSpendingByPeriod($userId, $periodId);

            $executionTime = round((microtime(true) - $start) * 1000);
            if ($executionTime > 2000) {
                Log::warning("Execution of transactionRepository->getSummaryTotalIncomeSpendingbyPeriod is slow", [
                    'user_id' => $userId,
                    'execution_time' => $executionTime,
                ]);
            }

            Log::error('get summary total income spending by period success', [
                'user_id' => $userId
            ]);

            return $result;
        } catch (\Throwable $th) {
            Log::error('get summary total income spending by period failed', [
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

    public function getTotalCategoryAllByPeriod(int $userId, int $periodId): ?Collection
    {
        try {
            $start = microtime(true);
            $transaction = $this->transactionRepository->getTotalCategoryAllByPeriod($userId, $periodId);

            $executionTime = round((microtime(true) - $start) * 1000);
            if ($executionTime > 2000) {
                Log::warning("Execution of transactionRepository->getTotalCategoryAllByPeriod is slow", [
                    'user_id' => $userId,
                    'execution_time' => $executionTime,
                ]);
            }

            Log::info('get total category all by period success', [
                'user_id' => $userId
            ]);

            return $transaction;
        } catch (\Throwable $th) {
            Log::error('get total category all by period failed', [
                'user_id' => $userId,
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }

    public function getTransactionByPeriod(int $userId, $periodId): ?Collection
    {
        try {
            $start = microtime(true);
            $transaction = $this->transactionRepository->getTransactionByPeriod($userId, $periodId);

            $executionTime = round((microtime(true) - $start) * 1000);
            if ($executionTime > 2000) {
                Log::warning("Execution of transactionRepository->getTransactionByPeriod is slow", [
                    'user_id' => $userId,
                    'execution_time' => $executionTime,
                ]);
            }

            Log::info('get transaction by period success', [
                'user_id' => $userId
            ]);

            return $transaction;
        } catch (\Throwable $th) {
            Log::error('get transaction by period failed', [
                'user_id' => $userId,
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }

    public function getAllPaging(int $userId, int $page): ?Collection
    {
        try {
            $skip = $page * 50 - 50;

            $transaction = Transaction::where('user_id', $userId)
                ->limit(50)
                ->offset($skip)
                ->orderByDesc('date')
                ->get();

            Log::info('get transaction by all paging success', [
                'user_id' => $userId
            ]);

            return $transaction;
        } catch (\Throwable $th) {
            Log::error('get transaction by all paging failed', [
                'user_id' => $userId,
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }

    public function update(int $userId, $transaction): ?Transaction
    {
        try {
            $dateCarbon = Carbon::createFromFormat('Y-m-d', $transaction->date)->setTime(0, 0, 0, 0);

            $period = $this->periodRepository->findOrCreate($userId, $dateCarbon->month, $dateCarbon->year);
            $category = Category::where('code', $transaction->category)->first();

            if ($category->type != $transaction->type) {
                throw new Exception("transaction type is invalid");
            }

            $income = $transaction->type == 'income' ? $transaction->value : 0;
            $spending = $transaction->type == 'spending' ? $transaction->value : 0;

            $transactionModel = Transaction::where('code', $transaction->code)->first();

            if (!$transactionModel) {
                throw new ModelNotFoundException("transaction with code $transaction->code not found");
            }

            $transactionModel->update([
                'period_id' => $period->id,
                'category_id' => $category->id,
                'date' => $dateCarbon,
                'description' => $transaction->description,
                'income' => $income,
                'spending' => $spending
            ]);

            Log::info('update transacrion success', [
                'user_id' => $userId,
            ]);

            return $transactionModel;
        } catch (\Throwable $th) {
            Log::error('update transaction failed', [
                'user_id' => $userId,
                'message' => $th->getMessage()
            ]);

            return null;
        }
    }

    public function delete(int $userId, string $code): void
    {
        try {
            $transaction = Transaction::where('code', $code)->first();

            if (!$transaction) {
                throw new ModelNotFoundException("transaction with code $code not found");
            }

            Log::info('delete transaction success', [
                'user_id' => $userId,
            ]);

            $transaction->delete();
        } catch (\Throwable $th) {
            Log::error('delete transaction failed', [
                'user_id' => $userId,
                'message' => $th->getMessage()
            ]);
        }
    }
}
