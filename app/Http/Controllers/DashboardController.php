<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Intranet\Ciclo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $ciclosActivos = Ciclo::where('estado', 1)->get();
        return view ('dashboard', ['ciclos' => $ciclosActivos]);
    }
}
