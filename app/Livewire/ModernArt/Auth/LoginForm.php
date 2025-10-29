<?php

namespace App\Livewire\ModernArt\Auth;

use App\Http\Requests\LoginRequest;
use App\Service\UserService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginForm extends Component
{
    private $userService;

    public $email;
    public $password;

    public function boot()
    {
        $this->userService = app()->make(UserService::class);
    }

    public function getRules()
    {
        return (new LoginRequest())->rules();
    }

    public function getListeners()
    {
        return [
            'redirect-to-dashboard' => 'redirectToDashboard'
        ];
    }

    public function doLogin()
    {
        $this->validate();

        $login = $this->userService->login($this->email, $this->password);

        $this->password = '';

        if (!is_null($login)) {
            Auth::login($login, true);

            $this->dispatch('show-login-success');
        }

        if (is_null($login)) {
            $this->dispatch('show-login-failed');
        }
    }

    public function redirectToDashboard()
    {
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.modern-art.auth.login-form');
    }
}
