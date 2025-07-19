<?php

namespace App\Livewire\ModernArt\Component;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{
    public function getListeners()
    {
        return [
            'do-logout' => 'doLogout'
        ];
    }

    public function hendleButtonLogout()
    {
        $this->dispatch('open-confirm-logout');
    }

    public function doLogout()
    {
        Auth::logout();

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.modern-art.component.navbar');
    }
}
