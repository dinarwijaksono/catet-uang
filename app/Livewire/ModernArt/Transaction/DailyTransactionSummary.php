<?php

namespace App\Livewire\ModernArt\Transaction;

use App\Service\TransactionService;
use Livewire\Component;

class DailyTransactionSummary extends Component
{
    protected $transactionService;
    public $dailyTransaction;

    public $nameDays;

    public function boot()
    {
        $this->nameDays = ['', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        $this->transactionService = app()->make(TransactionService::class);

        $this->dailyTransaction = $this->transactionService->getSummaryIncomeSpending(auth()->user()->id);
    }

    public function getListeners()
    {
        return [
            'do-refresh' => 'boot'
        ];
    }

    public function render()
    {
        return view('livewire.modern-art.transaction.daily-transaction-summary');
    }
}
