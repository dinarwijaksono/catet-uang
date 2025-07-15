<?php

namespace App\Livewire\ModernArt\Category;

use App\Http\Requests\CreateCategoryRequest;
use App\Service\CategoryService;
use Livewire\Component;

class CreateCategoryModal extends Component
{
    public $isOpen = false;

    public $name;
    public $type;

    public function getRules()
    {
        return (new CreateCategoryRequest())->rules();
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

        $this->name = '';
        $this->type = '';
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function save()
    {
        $this->validate();

        $categoryService = app()->make(CategoryService::class);

        $results = $categoryService->create(auth()->user()->id, $this->name, $this->type);

        if (is_null($results)) {
            $this->dispatch('show-create-category-failed');
        }

        if (!is_null($results)) {
            $this->dispatch('show-create-category-success');
        }
    }

    public function render()
    {
        return view('livewire.modern-art.category.create-category-modal');
    }
}
