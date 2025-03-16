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

    public $listPeriod;

    public $period;

    protected $transactionService;

    public function mount()
    {
        $this->period = 'all';
    }

    public function boot()
    {
        $this->transactionService = app()->make(TransactionService::class);

        $this->listPeriod = $this->transactionService->getAllPeriod(auth()->user()->id)->sortByDesc('period_date');

        $this->summaryTotal = $this->transactionService->getSummaryTotalIncomeSpendingAll(auth()->user()->id);
        $this->totalIncome = $this->summaryTotal->total_income;
        $this->totalSpending = $this->summaryTotal->total_spending;
        $this->diff = $this->totalIncome - $this->totalSpending;
    }

    public function getListeners()
    {
        return [
            'do-refresh' => 'render'
        ];
    }

    public function doChangePeriod()
    {
        if ($this->period == 'all') {
            $this->summaryTotal = $this->transactionService->getSummaryTotalIncomeSpendingAll(auth()->user()->id);
            $this->totalIncome = $this->summaryTotal->total_income;
            $this->totalSpending = $this->summaryTotal->total_spending;
            $this->diff = $this->totalIncome - $this->totalSpending;

            return;
        } else {

            $this->summaryTotal = $this->transactionService
                ->getSummaryTotalIncomeSpendingByPeriod(auth()->user()->id, $this->period);
            $this->totalIncome = $this->summaryTotal->total_income;
            $this->totalSpending = $this->summaryTotal->total_spending;
            $this->diff = $this->totalIncome - $this->totalSpending;
        }
    }

    public function render()
    {
        return view('livewire.report.box-summary-total');
    }
}
