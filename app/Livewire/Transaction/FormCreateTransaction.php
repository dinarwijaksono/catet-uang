<?php

namespace App\Livewire\Transaction;

use App\Http\Requests\CreateTransactionRequest;
use App\Livewire\Component\AlertDanger;
use App\Livewire\Component\AlertSuccess;
use App\Service\CategoryService;
use App\Service\TransactionService;
use Livewire\Component;

class FormCreateTransaction extends Component
{
    public $date;
    public $type = 'spending';
    public $category;
    public $value;
    public $description;

    public $hidden = true;
    public $val;

    public $listCategory;

    protected $categoryService;
    protected $transactionService;

    public function boot()
    {
        $this->categoryService = app()->make(CategoryService::class);
        $this->transactionService = app()->make(TransactionService::class);

        $this->listCategory = $this->categoryService->getAll(auth()->user()->id)
            ->where('type', $this->type)
            ->sortBy('name');
    }

    public function mount()
    {
        $this->val = 0;
    }

    public function getRules()
    {
        return (new CreateTransactionRequest())->rules();
    }

    public function getListeners()
    {
        return [
            'do-hide' => 'doHide',
            'do-show' => 'doShow'
        ];
    }

    public function doHide()
    {
        $this->hidden = true;
    }

    public function doShow()
    {
        $this->hidden = false;
    }

    public function doChangeType($type)
    {
        $this->type = $type;

        $this->listCategory = $this->categoryService
            ->getAll(auth()->user()->id)
            ->where('type', $this->type)
            ->sortBy('name');
    }

    public function doChangeValue($value)
    {
        if (is_numeric($value)) {
            $this->val = $value;
        } else {
            $this->val = 0;
        }
    }

    public function save()
    {
        $this->dispatch('do-hide')->to(AlertSuccess::class);
        $this->dispatch('do-hide')->to(AlertDanger::class);

        $this->validate();

        $income = $this->type == "income" ? $this->value : 0;
        $spending = $this->type == "spending" ? $this->value : 0;
        $result = $this->transactionService->create(auth()->user()->id, $this->category, $this->date, $this->description, $income, $spending);

        $this->doChangeType('spending');
        $this->value = 0;
        $this->description = 0;

        $this->doHide();

        if (is_null($result)) {
            $this->dispatch('do-show', "Transaksi gagal.")->to(AlertDanger::class);
        }

        if (!is_null($result)) {
            $this->dispatch('do-show', "Transaksi berhasil di tambahkan.")->to(AlertSuccess::class);
            $this->dispatch('do-refresh')->to(BoxTransactionInDate::class);
        }
    }

    public function render()
    {
        return view('livewire.transaction.form-create-transaction');
    }
}
