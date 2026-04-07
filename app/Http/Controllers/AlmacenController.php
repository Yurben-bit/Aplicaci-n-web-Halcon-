<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    public function dashboard()
    {
        return view('almacen.dashboard');
    }
}
