<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use App\Models\Intranet\Asignatura;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AsignaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datatable = $this->getData();

        $response = [
            'page' => 'Asignaturas',
            'title' => 'Asignatura',
            'datatable' => $datatable,
        ];

        return view('intranet.asignaturas.index')->with($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        Log::info('Un usuario ha iniciado sesión.', $request->all());


        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|string|max:255|min:5|regex:/^[\w\s\-]+$/u',
        ], [
            'descripcion.required' => ' La descripción es obligatoria',
            'descripcion.string' => ' La descripción debe ser un texto válido',
            'descripcion.max' => ' La descripción no puede superar los 50 caracteres',
            'descripcion.min' => ' La descripción no puede ser menos de 5 caracteres',
            'descripcion.regex' => ' La descripción solo puede contener letras, espacios y guiones',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            $docente = Asignatura::create($request->only(['descripcion','estado']));

            $dataTable = $this->getData();

            return response()->json([
                'success' => true,
                'message' => 'Asignatura creada exitosamente.',
                'datatable' => $dataTable,
            ], 201);
            
        } catch (\Exception $e) {
            // Log::error('Se produjo una excepción.', ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la asignatura',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Asignatura $asignatura)
    {
        return response()->json($asignatura);
    }

    public function update(Request $request, $asignatura)
    {
        try {
            $rules = [
                'descripcion' => 'required|string|max:255|regex:/^[\w\s\-]+$/u',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            $asignatura = Asignatura::findOrFail($asignatura);
            
            $asignatura->fill($request->only(['descripcion']));
            $asignatura->save();

            $datatable = $this->getData();

            return response()->json([
                'success' => true,
                'message' => 'Asignatura actualizada con éxito',
                // 'data' => $docente
                'datatable' => $datatable
            ], 200);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Asignatura no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la asignatura',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function eliminar(Asignatura $asignatura)
    {
        $deleted_status = 5; //Estado 5 significa eliminado
        try {
            $asignatura->estado = $deleted_status;
            $asignatura->save();

            $datatable = $this->getData();

            return response()->json([
                'success' => true,
                'message' => 'Asignatura eliminada con éxito',
                'datatable' => $datatable
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Asignatura no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el asignatura',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function getData()
    {

        $asignaturas = Asignatura::where('estado','REGEXP','^[^5]')->get();

        $html = "";
        foreach ($asignaturas as $item) {

            $id = $item->id;
            $descripcion = $item->descripcion;
            $estado = $item->estado;

            $acciones = "
                <a class='badge fw-semibold py-1 bg-primary-subtle text-primary btnEditAsignatura' data-id='$id' role='button'>
                    <i class='ti ti-edit'></i>                                        
                </a>
                <a class='badge fw-semibold py-1 bg-danger-subtle text-danger btnDeleteAsignatura' data-id='$id' role='button'>
                    <i class='ti ti-trash'></i>                                        
                </a>
            ";

            $estado = ($estado > 0) ? 'ACTIVO' : 'INACTIVO';

            $html .= "<tr>
                <td>$acciones</td>
                <td><span class='badge fw-semibold py-1 bg-primary-subtle text-primary'>$estado</span></td>
                <td>$descripcion</td>
            </tr>";
        }

        return $html;
    }

}
