<?php

namespace App\Livewire\ModernArt\Auth;

use App\Http\Requests\RegisterRequest;
use App\Service\UserService;
use Livewire\Component;

class RegisterForm extends Component
{
    private $userService;

    public $name;
    public $email;
    public $password;
    public $confirmation_password;

    public function boot()
    {
        $this->userService = app()->make(UserService::class);
    }

    public function getListeners()
    {
        return [
            'redirect-to-dashboard' => 'doRedirectToDashboard'
        ];
    }

    public function getRules()
    {
        return (new RegisterRequest())->rules();
    }

    public function doRegister()
    {
        $this->validate();

        $register = $this->userService->register($this->name, $this->email, $this->password);

        $this->password = "";
        $this->confirmation_password = "";

        if (!is_null($register)) {
            $this->dispatch('show-register-success');
        }

        if (is_null($register)) {
            $this->dispatch('show-register-failed');
        }
    }

    public function doRedirectToDashboard()
    {
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.modern-art.auth.register-form');
    }
}
