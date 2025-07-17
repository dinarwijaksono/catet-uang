<?php

namespace App\Livewire\ModernArt\Transaction;

use App\Service\TransactionService;
use Carbon\Carbon;
use Livewire\Component;

class TransactionInDate extends Component
{
    public $date;
    public $day;

    public $transactions;

    private $transactionService;

    public function boot()
    {
        $this->day = Carbon::createFromFormat('Y-m-d', $this->date);

        $this->transactionService = app()->make(TransactionService::class);

        $this->transactions = $this->transactionService->getByDate(auth()->user()->id, $this->day);
    }

    public function render()
    {
        return view('livewire.modern-art.transaction.transaction-in-date');
    }
}
