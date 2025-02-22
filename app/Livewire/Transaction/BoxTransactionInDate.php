<?php

namespace App\Livewire\Transaction;

use App\Service\TransactionService;
use Carbon\Carbon;
use Livewire\Component;

class BoxTransactionInDate extends Component
{
    public $date;
    public $listTransaction;

    public function boot()
    {
        $transactionService = app()->make(TransactionService::class);

        $this->listTransaction = $transactionService->getByDate(auth()->user()->id, Carbon::create($this->date))
            ->sortBy('created_at');
    }

    public function getListeners()
    {
        return [
            'do-refresh' => 'render'
        ];
    }

    public function doShowFormCreateTransaction()
    {
        $this->dispatch('do-show')->to(FormCreateTransaction::class);
    }

    public function render()
    {
        return view('livewire.transaction.box-transaction-in-date');
    }
}
