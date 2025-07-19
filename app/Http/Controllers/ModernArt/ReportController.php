<?php

namespace App\Http\Controllers\ModernArt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('modern-art.report.index');
    }
}
