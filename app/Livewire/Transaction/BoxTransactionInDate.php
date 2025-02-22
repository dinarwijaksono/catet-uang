<?php

namespace App\Livewire\Transaction;

use Livewire\Component;

class BoxTransactionInDate extends Component
{
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
