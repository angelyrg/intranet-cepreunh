<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ciclos\StoreCicloRequest;
use App\Http\Requests\Ciclos\UpdateCicloRequest;
use App\Models\Intranet\Ciclo;
use App\Models\Intranet\HorarioEstudiante;
use App\Models\Intranet\MaterialEntregable;
use App\Models\Intranet\TiposCiclos;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CicloController extends Controller
{
    public function index()
    {
        $tipos_ciclos = TiposCiclos::all();
        $datatable = $this->getData();

        $response = [
            'page' => 'Ciclos Académicos',
            'title' => 'Ciclo Académico',
            'slug' => 'Ciclos',
            'datatable' => $datatable,
            'tipos_ciclos' => $tipos_ciclos,
        ];

        return view('intranet.ciclos.index')->with($response);
    }

    public function store(StoreCicloRequest $request)
    {
        try {
            $data = $request->only(['descripcion', 'fecha_inicio', 'fecha_fin', 'duracion', 'tipos_ciclos_id']);
            $data['dias_lectivos'] = $request->dias_lectivos ? implode(',', $request->dias_lectivos) : null;

            $ciclo = Ciclo::create($data);

            $dataTable = $this->getData();

            return response()->json([
                'success' => true,
                'message' => 'Ciclo creado exitosamente.',
                'datatable' => $dataTable,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Se produjo una excepción.', ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el ciclo: ' . $e->getMessage(),
                'error' => $e
            ], 500);
        }
    }

    public function edit(Ciclo $ciclo)
    {
        return response()->json($ciclo);
    }

    public function update(UpdateCicloRequest $request, Ciclo $ciclo)
    {
        try {
            $validatedData = $request->validated();

            $validatedData['dias_lectivos'] = $validatedData['dias_lectivos'] ? implode(',', $validatedData['dias_lectivos']) : null;

            $ciclo->update($validatedData);

            $datatable = $this->getData();

            return response()->json([
                'success' => true,
                'message' => 'Ciclo actualizado con éxito',
                'datatable' => $datatable
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el ciclo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $diasDeLaSemana = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
            7 => 'Domingo',
        ];

        $ciclo = Ciclo::with(
            'asignaturaCiclos',
            'tipo_ciclo',
            'carreras.area',
            'asignaturas',
            'matriculas.estudiante',
            'matriculas.estudiante.genero',
            'matriculas.area',
            'matriculas.carrera',
            'matriculas.sede',
            'precios',
        )->findOrFail($id);

        // Formatear las fechas
        $ciclo->fecha_inicio = Carbon::parse($ciclo->fecha_inicio)->format('d/m/Y');
        $ciclo->fecha_fin = Carbon::parse($ciclo->fecha_fin)->format('d/m/Y');

        $ciclo->dias_lectivos = ($ciclo->dias_lectivos != null) ? explode(',', $ciclo->dias_lectivos) : [];
        $ciclo->dias_lectivos_texto = array_map(function ($dia) use ($diasDeLaSemana) {
            return $diasDeLaSemana[$dia] ?? '';
        }, $ciclo->dias_lectivos);

        $sedeId = Auth::check() && Auth::user()->can('sedes.ver_todas')
            ? null
            : Auth::user()->sede_id;
        
        return view('intranet.ciclos.show', compact('ciclo', 'sedeId'));
    }


    private function getData()
    {
        $ciclos = Ciclo::with('tipo_ciclo')->get();
        $user = Auth::user();

        $html = "";
        foreach ($ciclos as $item) {
            $id = $item->id;
            $descripcion = $item->descripcion;
            $fecha_inicio = (new DateTime($item->fecha_inicio))->format('d/m/Y');
            $fecha_fin = (new DateTime($item->fecha_fin))->format('d/m/Y');
            $duracion = $item->duracion . " semanas";
            $tipo_ciclo = $item->tipo_ciclo->descripcion;
            $estado = $item->estado;
            $fecha_creacion = (new DateTime($item->created_at))->format('d/m/Y');

            $acciones = "<div class='btnActionCarrera d-flex gap-1'>";

            // Verificar permiso para editar
            if ($user->can('ciclo.editar')) {
                $acciones .= "<a class='btn btn-sm btn-outline-primary btnEdit' data-id='$id' role='button'>
                            <i class='ti ti-edit'></i>                                        
                        </a>";
            }

            // Verificar permiso para eliminar
            if ($user->can('ciclo.eliminar')) {
                $acciones .= "<a class='btn btn-sm btn-outline-danger btnDelete' data-id='$id' role='button'>
                            <i class='ti ti-trash'></i>                                        
                        </a>";
            }

            $acciones .= "</div>";

            if ($estado > 0) {
                $estado = "<span class='badge bg-primary-subtle fw-semibold text-primary'>ACTIVO</span>";
            } else {
                $estado = "<span class='badge bg-danger-subtle fw-semibold text-danger'>INACTIVO</span>";
            }

            if ($user->can('ciclo.detalles')) {
                $cicloDetalleEnlace = "<a href=" . route('ciclos.show', $id) . " class='text-decoration-underline fw-bold'>$descripcion</a>";
            } else {
                $cicloDetalleEnlace = $descripcion;
            }

            $actionsDropdown = '
                                    <div class="dropdown dropstart">
                                        <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots fs-5"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                                            

            if ($user->can('ciclo.detalles')) {
                $actionsDropdown .= '<li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="' . route('ciclos.show', $id) . '">
                                            <i class="fs-4 ti ti-users"></i>Matriculados
                                        </a>
                                    </li>';
            }
            
            if ($user->can('pagos.lista')) {
                $actionsDropdown .= '<li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="' . route('ciclos.pagos', $id) . '">
                                            <i class="fs-4 ti ti-coin"></i> Reporte pagos
                                        </a>
                                    </li>';
                                }
            
            if ($user->can('entrega.crear')) {
                $actionsDropdown .= '<li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="' . route('ciclos.entregas', $id) . '">
                                            <i class="fs-4 ti ti-book-2"></i> Entrega de materiales
                                        </a>
                                    </li>';
                                }

            $actionsDropdown .= '</ul>
                            </div>';
                                

            $html .= "<tr>
                <td>$actionsDropdown</td>
                <td>$acciones</td>
                <td>$estado</td>
                <td>$cicloDetalleEnlace</td>
                <td>$fecha_inicio</td>
                <td>$fecha_fin</td>
                <td>$duracion</td>
                <td>$tipo_ciclo</td>
                <td>$fecha_creacion</td>
            </tr>";
        }

        return $html;
    }

    public function eliminar(Ciclo $ciclo)
    {
        try {
            $ciclo->delete(); //softdelete            
            $ciclo->save();
            $datatable = $this->getData();

            return response()->json([
                'success' => true,
                'message' => 'Ciclo eliminada con éxito',
                'datatable' => $datatable
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ciclo no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el ciclo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function pagosReporte($id)
    {
        $ciclo = Ciclo::findOrFail($id);

        $sedeId = Auth::check() && Auth::user()->can('sedes.ver_todas')
            ? null
            : Auth::user()->sede_id;

        return view('intranet.ciclos.pagos', compact('ciclo', 'sedeId'));
    }

    public function matricula($ciclo)
    {
        $ciclo = Ciclo::findOrFail($ciclo);
        $page = 'Matrícula';
        $title = 'Matrícula';
        $slug = 'Matricula';

        return view('intranet.ciclos.matricula', compact('page', 'title', 'slug', 'ciclo'));
    }


    public function create_precios(Ciclo $ciclo)
    {
        return view("intranet.ciclos.create_precios", compact('ciclo'));
    }

    public function asignar_carreras(Ciclo $ciclo)
    {
        return view("intranet.ciclos.asignar_carreras", compact('ciclo'));
    }
    
    public function asignar_asignaturas(Ciclo $ciclo)
    {
        return view("intranet.ciclos.asignar_asignaturas", compact('ciclo'));
    }
    
    public function entregas(Ciclo $ciclo)
    {
        $materiales_entregables = MaterialEntregable::all();
        return view("intranet.ciclos.entregas", compact('ciclo', 'materiales_entregables'));
    }

    /**
     * @param  int  $ciclo
     * @param  int  $sede
     * @return \Illuminate\Http\JsonResponse
     */    
    public function horario($ciclo)
    {
        $sede = Auth::user()->sede_id;

        $horario_de_estudiantes = HorarioEstudiante::where('ciclo_id', $ciclo)
            ->where('sede_id', $sede)
            ->first();

        if (!$horario_de_estudiantes) {
            return response()->json([
                'error' => 'No se encontró el horario para este ciclo y sede. Por favor comuníquese con el administrador del sistema.',
            ], 404);
        }

        return response()->json([
            'message' => 'Horario encontrado.',
            'horario_de_estudiantes' => $horario_de_estudiantes,
        ], 200);

    }
}
