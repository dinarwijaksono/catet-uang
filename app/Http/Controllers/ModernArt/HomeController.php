<?php

namespace App\Http\Controllers\ModernArt;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('modern-art.home.index');
    }

    public function detailTransaction($date)
    {
        $data['date'] = Carbon::createFromFormat('Y-M-d', $date)->getTimestamp();

        return view('modern-art.home.transaction-detail', $data);
    }
}
