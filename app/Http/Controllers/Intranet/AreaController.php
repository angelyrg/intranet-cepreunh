<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use App\Models\Intranet\Area;
use App\Models\intranet\Carrera;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataTable = $this->getData();
        
        $response = [
            'datatable' => $dataTable,
        ];
        $response = [
            'page' => 'Áreas',
            'title' => 'Area',
            'datatable' => $dataTable,
        ];

        return view('intranet.areas.index')->with($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descripcion' => 'sometimes|string|max:255|regex:/^[\w\s\-]+$/u'
        ], [
            'descripcion.required' => 'La descripción es obligatoria',
            'descripcion.string' => 'La descripción debe ser un texto válido',
            'descripcion.max' => 'La descripción no puede superar los 255 caracteres',
            'descripcion.regex' => 'La descripción solo puede contener letras, espacios y guiones',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            $area = Area::create($request->only(['descripcion']));

            $dataTable = $this->getData();

            return response()->json([
                'success' => true,
                'message' => 'Areaa creada exitosamente.',
                'datatable' => $dataTable,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el área',
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        return response()->json($area);     
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'descripcion' => 'sometimes|string|max:255|regex:/^[\w\s\-]+$/u'
        ], [
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.string' => 'La descripción debe ser un texto válido.',
            'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',
            'descripcion.regex' => 'La descripción solo puede contener letras, espacios y guiones.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            $area = Area::findOrFail($id);

            $area->fill($request->only([ 'descripcion' ]));
            $area->save();

            $datatable = $this->getData();

            return response()->json([
                'success' => true,
                'message' => 'Área actualizada con éxito',
                'datatable' => $datatable
            ], 200);

        } catch ( ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Área no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el área',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function eliminar(Area $area)
    {
        $deleted_status = 5; //Estado 5 significa eliminado
        try {
            $area->estado = $deleted_status;
            $area->save();

            $datatable = $this->getData();

            return response()->json([
                'success' => true,
                'message' => 'Área eliminada con éxito',
                'datatable' => $datatable
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Área no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el área',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    

    private function getData(){
        $areas = Area::where('estado', '!=', 5)->get();


        $html = "";
        foreach ($areas as $item) {
            $id = $item->id;
            $descripcion = $item->descripcion;
            $estado = $item->estado;

            $acciones = "
            <div class='btnActionCarrera'>
                <a class='btn badge fw-semibold py-1 bg-primary-subtle text-primary btnEdit' data-id='$id' role='button'>
                    <i class='ti ti-edit'></i>
                </a>
                <a class='btn badge fw-semibold py-1 bg-danger-subtle text-danger btnDelete' data-id='$id' role='button'>
                    <i class='ti ti-trash'></i>
                </a>
            </div>
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
