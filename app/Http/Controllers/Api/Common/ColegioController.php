<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\Controller;
use App\Models\Common\Colegio;
use Illuminate\Http\Request;

class ColegioController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'ubigeo' => 'nullable|string|exists:ubigeodistrito,id',
        ]);

        if ($request->has('ubigeo')) {
            $distritos = Colegio::where('codgeo', $request->ubigeo)->get();
            return response()->json([
                'success' => true,
                'data' => $distritos,
            ]);
        }

        $departamentos = Colegio::all();
        return response()->json([
            'success' => true,
            'data' => $departamentos,
        ]);
    }
}
