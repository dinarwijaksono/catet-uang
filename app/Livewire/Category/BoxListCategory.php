<?php

namespace App\Livewire\Category;

use App\Livewire\Component\AlertDanger;
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

    public function doShowFormUpdateCategory(string $categoryCode)
    {
        $this->dispatch('do-show', $categoryCode)->to(FormUpdateCategory::class);
    }

    public function deleteCategory(string $code)
    {
        $this->dispatch('do-hide')->to(AlertSuccess::class);
        $this->dispatch('do-hide')->to(AlertDanger::class);

        $category = $this->categoryService->findByCode(auth()->user()->id, $code);
        $check = !$category ? true : $this->categoryService->checkIsStillUse(auth()->user()->id, $category->id);

        if ($check) {
            $this->dispatch('do-show', "Kategori gagal dihapus, karena kategori digunakan pada transaksi.")
                ->to(AlertDanger::class);

            return;
        }

        $this->categoryService->delete(auth()->user()->id, $code);

        $this->dispatch('do-refresh')->self();
        $this->dispatch('do-show', "Kategori berhasil dihapus.")->to(AlertSuccess::class);
    }

    public function render()
    {
        return view('livewire.category.box-list-category');
    }
}
