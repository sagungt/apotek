<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        return view('stocks.index');
    }

    public function request()
    {
        return view('stocks.request');
    }

    public function expiry()
    {
        return view('stocks.expiry');
    }

    public function stockHistory()
    {
        return view('stocks.history');
    }
}
