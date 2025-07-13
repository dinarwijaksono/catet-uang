<?php

namespace App\Livewire\Category;

use App\Http\Requests\CreateCategoryRequest;
use App\Livewire\Component\AlertDanger;
use App\Livewire\Component\AlertSuccess;
use App\Service\CategoryService;
use Livewire\Component;

class FormUpdateCategory extends Component
{
    public $name;
    public $type = 'spending';

    public $hidden = true;

    protected $categoryService;

    public $categoryCode;

    public function boot()
    {
        $this->categoryService = app()->make(CategoryService::class);
    }

    public function rules()
    {
        return (new CreateCategoryRequest())->rules();
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

    public function doShow($categoryCode)
    {
        $this->hidden = false;
        $this->categoryCode = $categoryCode;

        $category = $this->categoryService->findByCode(auth()->user()->id, $categoryCode);
        $this->name = $category->name;
        $this->type = $category->type;
    }

    public function save()
    {
        $this->validate();
        $this->dispatch('do-hide')->to(AlertSuccess::class);
        $this->dispatch('do-hide')->to(AlertDanger::class);

        $result = $this->categoryService->update(auth()->user()->id, $this->categoryCode, $this->name);

        $this->dispatch('do-hide')->self();

        if (!is_null($result)) {
            $this->dispatch('do-refresh')->to(BoxListCategory::class);
            $this->dispatch('do-show', "Kategori berhasil diedit.")->to(AlertSuccess::class);
        }

        if (is_null($result)) {
            $this->dispatch('do-show', "Kategori gagal diedit.")->to(AlertDanger::class);
        }
    }

    public function render()
    {
        return view('livewire.category.form-update-category');
    }
}
