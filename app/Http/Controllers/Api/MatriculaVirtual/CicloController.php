<?php

namespace App\Http\Controllers\Api\MatriculaVirtual;

use App\Http\Controllers\Controller;
use App\Models\Intranet\Ciclo;

class CicloController extends Controller
{
    public function obtenerCiclosActivos()
    {
        $ciclos = Ciclo::where('estado', 1)
            ->select('id', 'descripcion', 'fecha_inicio', 'fecha_fin', 'duracion')
            ->get();

        return response()->json([
            'success' => true,
            'ciclos' => $ciclos,
        ], 200);
    }
}
