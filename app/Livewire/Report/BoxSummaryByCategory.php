<?php

namespace App\Livewire\Report;

use App\Service\TransactionService;
use Livewire\Component;

class BoxSummaryByCategory extends Component
{
    public $period;
    public $listTotalCategory;

    public $listPeriod;

    protected $transactionService;

    public function getListeners()
    {
        return [
            'do-refresh' => 'render'
        ];
    }

    public function mount()
    {
        $this->transactionService = app()->make(TransactionService::class);
        $listPeriod = $this->transactionService->getAllPeriod(auth()->user()->id)
            ->sortByDesc('period_date');

        if ($listPeriod->count() != 0) {

            $this->period = $listPeriod->first()->id;
        }
    }

    public function boot()
    {
        $this->transactionService = app()->make(TransactionService::class);
        $this->listPeriod = $this->transactionService->getAllPeriod(auth()->user()->id)
            ->sortByDesc('period_date');

        if ($this->listPeriod->count() != 0) {

            $this->listTotalCategory = $this->transactionService->getTotalCategoryAllByPeriod(auth()->user()->id, $this->listPeriod->first()->id)
                ->sortBy('category_name');
        }
    }

    public function doChangePeriod()
    {
        $this->listTotalCategory = $this->transactionService->getTotalCategoryAllByPeriod(auth()->user()->id, $this->period)
            ->sortBy('category_name');
    }

    public function render()
    {
        return view('livewire.report.box-summary-by-category');
    }
}
