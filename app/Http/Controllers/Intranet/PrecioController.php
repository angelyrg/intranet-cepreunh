<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrecioController extends Controller
{
    public function index()
    {
        return view('intranet.precios.index');
    }
}
