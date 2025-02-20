<?php

namespace App\Livewire\Category;

use App\Http\Requests\CreateCategoryRequest;
use App\Service\CategoryService;
use Livewire\Component;

class FormCreateCategory extends Component
{
    public $name;
    public $type = 'spending';

    public $hidden = true;

    protected $categoryService;

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

    public function doShow()
    {
        $this->hidden = false;
    }

    public function doChangeType($type)
    {
        $this->type = $type;
    }

    public function save()
    {
        $this->validate();

        $result = $this->categoryService->create(auth()->user()->id, $this->name, $this->type);

        $this->name = "";
        $this->type = "spending";

        $this->dispatch('do-hide')->self();
        $this->dispatch('do-refresh')->to(BoxListCategory::class);
    }

    public function render()
    {
        return view('livewire.category.form-create-category');
    }
}
