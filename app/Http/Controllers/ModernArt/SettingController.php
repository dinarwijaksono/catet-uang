<?php

namespace App\Http\Controllers\ModernArt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('modern-art.setting.index');
    }
}
