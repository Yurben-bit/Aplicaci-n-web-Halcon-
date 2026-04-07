<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function dashboard()
    {
        return view('venta.dashboard');
    }
}
