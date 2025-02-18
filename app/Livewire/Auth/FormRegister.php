<?php

namespace App\Livewire\Auth;

use App\Http\Requests\RegisterRequest;
use App\Service\UserService;
use Livewire\Component;

class FormRegister extends Component
{
    public $name;
    public $email;
    public $password;
    public $confirmation_password;

    protected $userService;

    public function boot()
    {
        $this->userService = app()->make(UserService::class);
    }

    public function rules()
    {
        return (new RegisterRequest())->rules();
    }

    public function save()
    {
        $this->validate();

        $response = $this->userService->register($this->name, $this->email, $this->password);

        if (is_null($response)) {
            $this->addError('general', "Email tidak valid.");

            return;
        }

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.auth.form-register');
    }
}
