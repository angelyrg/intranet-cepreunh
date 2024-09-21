<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use App\Models\Intranet\Carrera;
use App\Models\Intranet\Area;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CarreraController extends Controller
{
    public function index()
    {

        $areas = Area::all();
        $dataTable = $this->getData();

        $response = [
            'areas' => $areas,
            'datatable' => $dataTable,
        ];

        return view('intranet.carreras.index')->with($response);
    }

    public function create()
    {
        return view('intranet.areas.create');
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'area_id' => [
                'required',
                'exists:areas,id',
                function ($attribute, $value, $fail) {
                    if (!Area::where('id', $value)->where('estado', 1)->exists()) {
                        $fail('El área seleccionada no está activa.');
                    }
                },
            ],
            'descripcion' => 'sometimes|string|max:255|regex:/^[\w\s\-]+$/u',
            'estado' => 'sometimes',
        ], [
            'area_id.required' => 'El campo área es obligatorio.',
            'area_id.exists' => 'El área seleccionada no es válida.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.string' => 'La descripción debe ser un texto válido.',
            'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',
            'descripcion.regex' => 'La descripción solo puede contener letras, espacios y guiones.',
            'estado.required' => 'El campo estado es obligatorio.',
            'estado.boolean' => 'El estado debe ser verdadero o falso.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            $carrera = Carrera::create($request->only(['area_id', 'descripcion', 'estado']));

            $dataTable = $this->getData();

            return response()->json([
                'success' => true,
                'message' => 'Carrera creada exitosamente.',
                'datatable' => $dataTable,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la carrera',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Carrera $carrera)
    {
        return view('carreras.show', compact('carrera'));
    }

    public function edit(Carrera $carrera)
    {
        // return view('carreras.edit', compact('carrera'));
        return response()->json($carrera);
    }

    public function update(Request $request, $carrera)
    {
        try {
            $rules = [
                'area_id' => 'sometimes|exists:areas,id',
                'descripcion' => 'sometimes|string|max:255|regex:/^[\w\s\-]+$/u',
                'estado' => 'sometimes|integer|in:0,1,2,3,4,5',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            $carrera = Carrera::findOrFail($carrera);
            
            $carrera->fill($request->only(['area_id', 'descripcion', 'estado']));
            $carrera->save();

            $datatable = $this->getData();

            return response()->json([
                'success' => true,
                'message' => 'Carrera actualizada con éxito',
                'datatable' => $datatable
                // 'data' => $carrera
            ], 200);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Carrera no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la carrera',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    private function getData()
    {

        $carreras = DB::table('carreras')
            ->join('areas', 'carreras.area_id', '=', 'areas.id')
            ->select('carreras.*', 'areas.descripcion as descarea')
            ->where('carreras.estado','REGEXP','^[^5]')
            ->get();

        $html = "";
        foreach ($carreras as $item) {
            $id = $item->id;
            $descarea = $item->descarea;
            $descripcion = $item->descripcion;
            $estado = $item->estado;

            $acciones = "
            <div class='btnActionCarrera'>
                <a class='badge fw-semibold py-1 bg-primary-subtle text-primary btnEditCarrera' data-id='$id' role='button'>
                    <i class='ti ti-edit'></i>                                        
                </a>
                <a class='badge fw-semibold py-1 bg-danger-subtle text-danger btnDeleteCarrera' data-id='$id' role='button'>
                    <i class='ti ti-trash'></i>                                        
                </a>
            </div>
            ";

            $estado = ($estado > 0) ? 'ACTIVO' : 'INACTIVO';

            $html .= "<tr>
                <td>$acciones</td>
                <td>$estado</td>
                <td>$descarea</td>
                <td>$descripcion</td>
            </tr>";
        }

        return $html;
    }
}
