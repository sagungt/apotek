<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedicimeController extends Controller
{
    public function index()
    {
        return view('medicines');
    }
}
