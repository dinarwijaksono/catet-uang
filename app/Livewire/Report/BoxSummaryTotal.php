<?php

namespace App\Livewire\Report;

use App\Service\TransactionService;
use Livewire\Component;

class BoxSummaryTotal extends Component
{
    public $summaryTotal;
    public $totalIncome;
    public $totalSpending;
    public $diff;

    protected $transactionService;

    public function boot()
    {
        $this->transactionService = app()->make(TransactionService::class);

        $this->summaryTotal = $this->transactionService->getSummaryTotalIncomeSpendingAll(auth()->user()->id);
        $this->totalIncome = $this->summaryTotal->total_income;
        $this->totalSpending = $this->summaryTotal->total_spending;
        $this->diff = $this->totalIncome - $this->totalSpending;
    }

    public function render()
    {
        return view('livewire.report.box-summary-total');
    }
}
