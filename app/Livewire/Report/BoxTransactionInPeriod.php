<?php

namespace App\Livewire\Report;

use App\Livewire\Transaction\FormUpdateTransaction;
use App\Service\TransactionService;
use Livewire\Component;

class BoxTransactionInPeriod extends Component
{
    public $listPeriod;
    public $periodSelect;

    public $listTransaction;

    protected $transactionService;

    public function boot()
    {
        $this->transactionService = app()->make(TransactionService::class);

        $this->listPeriod = $this->transactionService->getAllPeriod(auth()->user()->id)
            ->sortByDesc('period_date');

        if (count($this->listPeriod) != 0) {

            $this->periodSelect = $this->listPeriod->first()->id;

            $this->listTransaction = $this->transactionService->getTransactionByPeriod(auth()->user()->id, $this->periodSelect)
                ->sortByDesc('date');
        }
    }

    public function getListeners()
    {
        return [
            'do-refresh' => 'render'
        ];
    }

    public function doChangePeriod()
    {
        $this->transactionService = app()->make(TransactionService::class);

        $this->listTransaction = $this->transactionService->getTransactionByPeriod(auth()->user()->id, $this->periodSelect)
            ->sortByDesc('date');
    }

    public function doShowFormUpdate($code)
    {
        $this->dispatch('do-show', $code)->to(FormUpdateTransaction::class);
    }

    public function doDeleteTransaction($code)
    {
        $this->transactionService->delete(auth()->user()->id, $code);

        $this->dispatch('do-refresh')->self();
    }

    public function render()
    {
        return view('livewire.report.box-transaction-in-period');
    }
}
