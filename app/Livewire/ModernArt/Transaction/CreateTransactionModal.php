<?php

namespace App\Livewire\ModernArt\Transaction;

use App\Http\Requests\CreateTransactionRequest;
use App\Models\Category;
use App\Service\CategoryService;
use App\Service\TransactionService;
use Livewire\Component;

class CreateTransactionModal extends Component
{
    public $isOpen = false;

    public $date;
    public $type;
    public $category;
    public $value;
    public $description;

    public $categories;

    protected $categoryService;

    public $valueShow;

    public function mount()
    {
        $this->valueShow = 0;

        $this->categoryService = app()->make(CategoryService::class);

        $this->categories = $this->categoryService->getAll(auth()->user()->id)->sortBy('name');
    }

    public function boot()
    {
        $this->categoryService = app()->make(CategoryService::class);
    }

    public function getRules()
    {
        return (new CreateTransactionRequest())->rules();
    }

    public function getListeners()
    {
        return [
            'set-open' => 'setOpen',
            'set-hide' => 'setHidden'
        ];
    }

    public function setOpen()
    {
        $this->isOpen = true;
    }

    public function setHidden()
    {
        $this->isOpen = false;

        $this->type = '';
        $this->category = '';
        $this->value = 0;
        $this->description = '';
    }

    public function setType($type)
    {
        $this->type = $type;

        $this->categories = $this->categoryService->getAll(auth()->user()->id)->where('type', $type)->sortBy('name');
        $this->category = '';
    }

    public function setValue($value)
    {
        $this->valueShow = $value;
    }

    public function save()
    {
        $this->validate();

        $categorySelect = Category::where('id', $this->category)->first();
        if ($this->type != $categorySelect->type) {
            $this->addError('category', 'Kategori tidak sama dengan type yang dipilih.');

            return;
        }

        $transactionService = app()->make(TransactionService::class);

        $income = $this->type == 'income' ? $this->value : 0;
        $spending = $this->type == 'spending' ? $this->value : 0;
        $results = $transactionService->create(auth()->user()->id, $this->category, $this->date, $this->description, $income, $spending);

        if (is_null($results)) {
            $this->dispatch('show-create-transaction-failed');
        }

        if (!is_null($results)) {
            $this->dispatch('show-create-transaction-success');
            $this->dispatch('do-refresh')->to(DailyTransactionSummary::class);
        }
    }

    public function render()
    {
        return view('livewire.modern-art.transaction.create-transaction-modal');
    }
}
