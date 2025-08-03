<?php

namespace App\Livewire\ModernArt\Report;

use App\Service\TransactionService;
use Livewire\Component;

class IncomeSpendingSummary extends Component
{
    protected $transactionService;

    public $transactionSummary;
    public $periods;
    public $difference;

    public $periodSelect;

    public function mount()
    {
        $this->transactionService = app()->make(TransactionService::class);
        $this->transactionSummary = $this->transactionService->getSummaryTotalIncomeSpendingAll(auth()->user()->id);
        $this->difference = $this->transactionSummary->total_income - $this->transactionSummary->total_spending;
    }

    public function boot()
    {
        $this->transactionService = app()->make(TransactionService::class);
        $this->periods = $this->transactionService->getAllPeriod(auth()->user()->id)->sortByDesc('period_date');
    }

    public function hendleButtonSearchByPeriod()
    {
        if ($this->periodSelect == 'all') {
            $this->transactionSummary = $this->transactionService->getSummaryTotalIncomeSpendingAll(auth()->user()->id);
            $this->difference = $this->transactionSummary->total_income - $this->transactionSummary->total_spending;
        } else {
            $this->transactionSummary = $this->transactionService->getSummaryTotalIncomeSpendingByPeriod(auth()->user()->id, $this->periodSelect);
            $this->difference = $this->transactionSummary->total_income - $this->transactionSummary->total_spending;
        }
    }

    public function render()
    {
        return view('livewire.modern-art.report.income-spending-summary');
    }
}
