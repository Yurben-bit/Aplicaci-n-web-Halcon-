<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function dashboard()
    {
        return view('compra.dashboard');
    }
}
