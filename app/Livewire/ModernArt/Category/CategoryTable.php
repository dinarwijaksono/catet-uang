<?php

namespace App\Livewire\ModernArt\Category;

use App\Service\CategoryService;
use Livewire\Component;

class CategoryTable extends Component
{
    public $categories;

    private $categoryService;

    public function boot()
    {
        $this->categoryService = app()->make(CategoryService::class);

        $this->categories = $this->categoryService->getAll(auth()->user()->id)->sortByDesc('created_at');
    }

    public function getListeners()
    {
        return [
            'do-refresh' => 'boot',
            'do-delete' => 'doDelete'
        ];
    }

    public function openConfirmDelete($code)
    {
        $this->dispatch('open-confirm-delete-category', code: $code);
    }

    public function doDelete($code)
    {
        $userId = auth()->user()->id;

        $category = $this->categoryService->findByCode($userId, $code);

        if ($this->categoryService->checkIsStillUse($userId, $category->id)) {
            $this->dispatch('show-delete-category-failed');

            return;
        }

        $this->categoryService->delete(auth()->user()->id, $code);

        $this->dispatch('show-delete-category-success');
    }

    public function openCreateCategoryModal()
    {
        $this->dispatch('set-open')->to(CreateCategoryModal::class);
    }

    public function render()
    {
        return view('livewire.modern-art.category.category-table');
    }
}
