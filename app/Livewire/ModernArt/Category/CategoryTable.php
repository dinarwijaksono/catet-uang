<?php

namespace App\Livewire\ModernArt\Category;

use Livewire\Component;

class CategoryTable extends Component
{
    public function openCreateCategoryModal()
    {
        $this->dispatch('set-open')->to(CreateCategoryModal::class);
    }

    public function render()
    {
        return view('livewire.modern-art.category.category-table');
    }
}
