<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use App\Models\Intranet\Estudiante;
use App\Models\Intranet\MaterialEntregable;
use App\Models\Intranet\Matricula;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EntregaController extends Controller
{
    public function buscar_matricula($dni, $ciclo_id)
    {
        try {
            $estudiante = Estudiante::where('nro_documento', $dni)->with(['matriculas' => function ($query) use ($ciclo_id) {
                $query->whereNull('deleted_at')
                    ->where('ciclo_id', $ciclo_id)
                    ->orderBy('created_at', 'desc')
                    ->with('entregas')->first();
            }])->first();

            if (!$estudiante) {
                return response()->json([
                    'error' => 'Estudiante no encontrado',
                ], 404);
            }

            if ($estudiante->matriculas->isEmpty()) {
                return response()->json([
                    'error' => 'No se encontró ninguna matrícula activa para este estudiante.',
                ], 404);
            }

            return response()->json([
                'estudiante' => $estudiante
            ], 200);

        } catch (\Exception $e) {
            // Capturar cualquier error inesperado
            return response()->json([
                'error' => 'Hubo un error inesperado al procesar la solicitud.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'material_entregable_id' => [
                'required',
                'integer',
                Rule::unique('entregas')->where(function ($query) use ($request) {
                    return $query->where('matricula_id', $request->matricula_id)
                        ->where('material_entregable_id', $request->material_entregable_id);
                })
            ],
            'matricula_id' => 'required|integer',
            'ciclo_id' => 'required|integer',
            'sede_id' => 'required|integer',
        ]);


        try {
            $matricula = Matricula::findOrFail($request->matricula_id);
            $material_entregable = MaterialEntregable::findOrFail($request->material_entregable_id);

            $entrega = $matricula->entregas()->create([
                'material_entregable_id' => $material_entregable->id,
                'ciclo_id' => $matricula->ciclo_id,
                'sede_id' => $request->sede_id,
                'usuario_registro_id' => Auth::id(),
                'estado' => 1,
            ]); 

            return response()->json([
                'entrega' => $entrega,
                'message' => 'Entrega registrada correctamente.'
            ], 201);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'No se encontró la matrícula o el material entregable.',
            ], 404);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Hubo un error al registrar la entrega del material.',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function getEntregasByMatricula($matricula_id)
    {
        try {
            $matricula = Matricula::findOrFail($matricula_id);
            $entregas = $matricula->entregas()->with('material_entregable')->get();

            return response()->json([
                'entregas' => $entregas
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'No se encontró la matrícula.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Hubo un error al obtener las entregas.',
                'message' => $e->getMessage()
            ], 500);
        }

    }
}
