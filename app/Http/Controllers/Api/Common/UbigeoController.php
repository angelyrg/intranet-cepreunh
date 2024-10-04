<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\Controller;
use App\Models\Common\UbigeoDepartamento;
use App\Models\Common\UbigeoDistrito;
use App\Models\Common\UbigeoProvincia;
use Illuminate\Http\Request;

class UbigeoController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'departamento' => 'nullable|string|exists:ubigeodepartamento,id',
            'provincia' => 'nullable|string|exists:ubigeoprovincia,id',
        ]);

        if ($request->has('provincia')) {
            $distritos = UbigeoDistrito::where('provincia', $request->provincia)->get();
            return response()->json([
                'success' => true,
                'data' => $distritos,
            ]);
        }

        if ($request->has('departamento')) {
            $provincias = UbigeoProvincia::where('departamento', $request->departamento)->get();
            return response()->json([
                'success' => true,
                'data' => $provincias,
            ]);
        }

        $departamentos = UbigeoDepartamento::all();
        return response()->json([
            'success' => true,
            'data' => $departamentos,
        ]);
    }
}
