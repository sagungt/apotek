<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.index');
    }

    public function request()
    {
        return view('orders.request');
    }
}
