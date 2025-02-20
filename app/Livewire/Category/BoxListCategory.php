<?php

namespace App\Livewire\Category;

use App\Livewire\Component\AlertSuccess;
use App\Service\CategoryService;
use Livewire\Component;

class BoxListCategory extends Component
{
    public $listCategory;

    protected $categoryService;

    public function boot()
    {
        $this->categoryService = app()->make(CategoryService::class);

        $this->listCategory = $this->categoryService->getAll(auth()->user()->id)->sortBy('name');
    }

    public function getListeners()
    {
        return [
            'do-refresh' => 'render'
        ];
    }

    public function toShowFormCreateCategory()
    {
        $this->dispatch('do-show')->to(FormCreateCategory::class);
    }

    public function deleteCategory(string $code)
    {
        $this->dispatch('do-hide')->to(AlertSuccess::class);

        $this->categoryService->delete(auth()->user()->id, $code);

        $this->dispatch('do-refresh')->self();
        $this->dispatch('do-show', "Kategori berhasil dihapus.")->to(AlertSuccess::class);
    }

    public function render()
    {
        return view('livewire.category.box-list-category');
    }
}
