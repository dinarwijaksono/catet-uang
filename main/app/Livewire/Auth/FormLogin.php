<?php

namespace App\Livewire\Auth;

use App\Http\Requests\LoginRequest;
use App\Service\UserService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormLogin extends Component
{
    public $email;
    public $password;

    protected UserService $userService;

    public function boot()
    {
        $this->userService = app()->make(UserService::class);
    }

    public function rules()
    {
        return (new LoginRequest())->rules();
    }

    public function login()
    {
        $this->validate();

        $login = $this->userService->login($this->email, $this->password);

        if (is_null($login)) {
            $this->password = '';

            $this->addError('general', 'Email atau password salah.');

            return;
        }

        Auth::login($login, true);

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.auth.form-login');
    }
}
