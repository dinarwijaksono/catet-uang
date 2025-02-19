<?php

namespace App\Livewire\Category;

use App\Service\CategoryService;
use Livewire\Component;

class BoxListCategory extends Component
{
    public $listCategory;

    protected $categoryService;

    public function boot()
    {
        $this->categoryService = app()->make(CategoryService::class);

        $this->listCategory = $this->categoryService->getAll(auth()->user()->id);
    }

    public function render()
    {
        return view('livewire.category.box-list-category');
    }
}
