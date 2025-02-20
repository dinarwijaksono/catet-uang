<?php

namespace App\Livewire\Component;

use Livewire\Component;

class AlertSuccess extends Component
{
    public $hidden = true;
    public $message;

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

    public function doShow(string $message = '')
    {
        $this->hidden = false;
        $this->message = $message;
    }

    public function render()
    {
        return view('livewire.component.alert-success');
    }
}
