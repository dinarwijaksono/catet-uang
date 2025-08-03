<?php

namespace App\Livewire\ModernArt\Report;

use App\Service\CategoryService;
use App\Service\TransactionService;
use Livewire\Component;

class CategoryTransactionReportTable extends Component
{
    protected $transactionService;

    public $periods;
    public $categories;
    public $transactions;

    public $periodSelect;

    public $totalIncome = 0;
    public $totalSpending = 0;

    public function boot()
    {
        $this->transactionService = app()->make(TransactionService::class);
        $this->periods = $this->transactionService->getAllPeriod(auth()->user()->id)
            ->sortByDesc('period_date');

        if (!$this->periods->isEmpty()) {
            $categoryService = app()->make(CategoryService::class);
            $this->categories = $categoryService->getAll(auth()->user()->id)
                ->sortBy('name');
        }
    }

    public function mount()
    {
        if (!$this->periods->isEmpty()) {
            $this->periodSelect = $this->periods->first()->id;

            $this->transactions = $this->transactionService->getTotalCategoryAllByPeriod(auth()->user()->id, $this->periodSelect);
        }
    }

    public function doChangePeriod()
    {
        if (!$this->periods->isEmpty()) {
            $this->transactions = $this->transactionService->getTotalCategoryAllByPeriod(auth()->user()->id, $this->periodSelect);
        }
    }

    public function render()
    {
        return view('livewire.modern-art.report.category-transaction-report-table');
    }
}
