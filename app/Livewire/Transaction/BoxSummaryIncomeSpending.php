<?php

namespace App\Livewire\Transaction;

use App\Service\TransactionService;
use Livewire\Component;

class BoxSummaryIncomeSpending extends Component
{
    public $summaryIncomeSpending;

    public function getListeners()
    {
        return [
            'do-refresh' => 'render'
        ];
    }

    public function boot()
    {
        $transactionService = app()->make(TransactionService::class);

        $this->summaryIncomeSpending = $transactionService->getSummaryIncomeSpending(auth()->user()->id);
    }

    public function render()
    {
        return view('livewire.transaction.box-summary-income-spending');
    }
}
