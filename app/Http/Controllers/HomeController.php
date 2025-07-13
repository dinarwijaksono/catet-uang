<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('Home.index');
    }

    public function detailTransactionInDate(int $date)
    {
        $data['date'] = $date;

        return view('Home.detail-transaction-in-date', $data);
    }
}
