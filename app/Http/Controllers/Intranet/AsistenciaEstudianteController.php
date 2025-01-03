<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Estudiantes\StoreAsistenciaEstudianteRequest;
use App\Models\Intranet\AsistenciaEstudiante;
use App\Models\Intranet\Ciclo;
use App\Models\Intranet\Estudiante;
use App\Models\Intranet\Matricula;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AsistenciaEstudianteController extends Controller
{

    public function registro()
    {
        $ciclos = Ciclo::all();
        return view('intranet.asistencia_estudiante.registro', compact('ciclos'));
    }


    /**
     * Almacenar un registro de asistencia.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dni_estudiante' => 'required|numeric|digits:8',
            'ciclo_id' => 'required|exists:ciclos,id',
        ]);

        try {
            $ciclo_id = $request->ciclo_id;

            $estudiante = Estudiante::where('nro_documento', $request->dni_estudiante)
                ->with(['matriculas' => function ($query) use ($ciclo_id) {
                    $query->whereNull('deleted_at')
                        ->where('ciclo_id', $ciclo_id)
                        ->orderBy('created_at', 'desc')
                        ->with(['area', 'carrera']);
                }])->first();

            if (!$estudiante) {
                return response()->json([
                    'error' => 'Estudiante no encontrado.',
                ], 404);
            }

            if ($estudiante->matriculas->isEmpty()) {
                return response()->json([
                    'error' => 'No se encontró ninguna matrícula activa para este estudiante.',
                ], 404);
            }

            $matricula = $estudiante->matriculas->first();

            // Validar que no haya un registro de asistencia en el mismo día
            $hoy = Carbon::today();
            $yaRegistrada = $matricula->asistencias()
                ->whereDate('entrada', $hoy)
                ->exists();

            if ($yaRegistrada) {
                return response()->json([
                    'error' => 'La asistencia ya fue registrada para este estudiante el día de hoy.',
                ], 422);
            }

            // Crear registro de asistencia
            $asistencia = $matricula->asistencias()->create([
                'estudiante_id' => $estudiante->id,
                'matricula_id' => $matricula->id,
                'ciclo_id' => $matricula->ciclo_id,
                'sede_id' => $matricula->sede_id,
                'usuario_registro_id' => Auth::id(),
                'estado' => 1, // 1: Presente 2: Tarde 3: Falta
                'entrada' => Carbon::now(),
            ]);

            return response()->json([
                'message' => 'Asistencia registrada correctamente.',
                'asistencia' => $asistencia,
                'estudiante' => $estudiante,
                'matricula' => $matricula,
            ], 201);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'No se encontró la matrícula.',
            ], 404);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Hubo un error al registrar la asistencia.',
                'message' => $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error inesperado.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function reporte(Request $request)
    {
        $sedeId = Auth::check() && Auth::user()->can('sedes.ver_todas')
            ? null
            : Auth::user()->sede_id;


        $ciclos = Ciclo::all();
        $estudiantes = Estudiante::all();
        
        $query = AsistenciaEstudiante::query();

        // Filtrar por ciclo si se pasa como parámetro
        if ($request->filled('ciclo_id')) {
            $query->where('ciclo_id', $request->ciclo_id);
        }

        // Filtrar por carrera_id y area_id de estudiante si se pasan como parámetros
        if ($request->filled('carrera_id')) {
            $query->whereHas('estudiante', function ($q) use ($request) {
                $q->where('carrera_id', $request->carrera_id);
            });
        }

        if ($request->filled('area_id')) {
            $query->whereHas('estudiante', function ($q) use ($request) {
                $q->where('area_id', $request->area_id);
            });
        }

        // Ejecutar la consulta y obtener las asistencias
        $asistencias = $query->get();

        // Retornar la vista con los datos
        return view('intranet.asistencia_estudiante.reporte', compact('asistencias', 'ciclos', 'estudiantes', 'sedeId'));
    }
}
