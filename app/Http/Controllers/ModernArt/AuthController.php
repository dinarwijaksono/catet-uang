<?php

namespace App\Http\Controllers\ModernArt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register()
    {
        return view('modern-art.auth.register');
    }
}
