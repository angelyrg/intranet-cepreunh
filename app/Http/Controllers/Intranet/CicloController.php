<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Intranet\Ciclos\StoreCicloRequest;
use App\Http\Requests\Intranet\Ciclos\UpdateCicloRequest;
use App\Models\Intranet\Ciclo;
use App\Models\Intranet\Docente;
use App\Models\Intranet\TiposCiclos;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
            $docente = Ciclo::create($request->only(['descripcion', 'fecha_inicio', 'fecha_fin', 'duracion', 'tipos_ciclos_id']));

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
                'message' => 'Error al crear el ciclo',
                'error' => $e->getMessage()
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


    private function getData()
    {
        $ciclos = Ciclo::all();

        $html = "";
        foreach ($ciclos as $item) {
            $id = $item->id;
            $descripcion = $item->descripcion;
            $fecha_inicio = (new DateTime($item->fecha_inicio))->format('d/m/Y');
            $fecha_fin = (new DateTime($item->fecha_fin))->format('d/m/Y');
            $duracion = $item->duracion." semanas";
            $tipo_ciclo = $item->tipo_ciclo->descripcion;
            $estado = $item->estado;
            $fecha_creacion = (new DateTime($item->created_at))->format('d/m/Y');

            $acciones = "
            <div class='btnActionCarrera'>
                <a class='btn btn-sm btn-outline-primary btnEdit' data-id='$id' role='button'>
                    <i class='ti ti-edit'></i>                                        
                </a>
                <a class='btn btn-sm btn-outline-danger btnDelete' data-id='$id' role='button'>
                    <i class='ti ti-trash'></i>                                        
                </a>
            </div>
            ";

            $estado = ($estado > 0) ? 'ACTIVO' : 'INACTIVO';

            $html .= "<tr>
                <td>$acciones</td>
                <td><span class='badge fw-semibold bg-primary-subtle text-primary'>$estado</span></td>
                <td>$descripcion</td>
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
}
