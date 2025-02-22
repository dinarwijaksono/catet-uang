<?php

namespace App\Livewire\Transaction;

use App\Livewire\Component\AlertSuccess;
use App\Service\TransactionService;
use Carbon\Carbon;
use Livewire\Component;

class BoxTransactionInDate extends Component
{
    public $date;
    public $listTransaction;

    protected $transactionService;

    public function boot()
    {
        $this->transactionService = app()->make(TransactionService::class);

        $this->listTransaction = $this->transactionService->getByDate(auth()->user()->id, Carbon::create($this->date))
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

    public function delete(string $code)
    {
        $this->dispatch('do-hide')->to(AlertSuccess::class);

        $this->transactionService->delete(auth()->user()->id, $code);

        $this->dispatch('do-refresh')->self();
        $this->dispatch('do-show', "Kategori berhasil di hapus.")->to(AlertSuccess::class);
    }

    public function render()
    {
        return view('livewire.transaction.box-transaction-in-date');
    }
}
