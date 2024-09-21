<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use App\Models\Intranet\Docente;
use App\Models\Intranet\Gradoacademico;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gradoacademico = Gradoacademico::all();
        $datatable = $this->getData();

        $response = [
            'page' => 'Docentes',
            'title' => 'Docente',
            'datatable' => $datatable,
            'gradoacademico' => $gradoacademico,
        ];

        return view('intranet.docentes.index')->with($response);

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
            'gradoacademico_id' => [
                'required',
                'exists:gradoacademico,id',
                function ($attribute, $value, $fail) {
                    if (!Gradoacademico::where('id', $value)->where('estado', 1)->exists()) {
                        $fail('El área seleccionada no está activa.');
                    }
                },
            ],
            'nombres' => 'required|string|max:50|regex:/^[\w\s\-]+$/u',
            'apellidos' => 'required|string|max:50|regex:/^[\w\s\-]+$/u',
            'genero' => 'required',
            'estado' => 'sometimes',
        ], [
            'gradoacademico_id.required' => 'El campo área es obligatorio.',
            'gradoacademico_id.exists' => 'El área seleccionada no es válida.',
            'nombres.required' => 'La descripción es obligatoria.',
            'nombres.string' => 'La descripción debe ser un texto válido.',
            'nombres.max' => 'La descripción no puede superar los 50 caracteres.',
            'nombres.regex' => 'La descripción solo puede contener letras, espacios y guiones.',
            'apellidos.required' => 'La descripción es obligatoria.',
            'apellidos.string' => 'La descripción debe ser un texto válido.',
            'apellidos.max' => 'La descripción no puede superar los 50 caracteres.',
            'apellidos.regex' => 'La descripción solo puede contener letras, espacios y guiones.',
            'genero.required' => 'El campo estado es obligatorio.',
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
            $docente = Docente::create($request->only(['gradoacademico_id','nombres','apellidos','genero','estado']));

            $dataTable = $this->getData();

            return response()->json([
                'success' => true,
                'message' => 'Carrera creada exitosamente.',
                'datatable' => $dataTable,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Se produjo una excepción.', ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la carrera',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Docente $docente)
    {
        //
    }

    public function edit(Docente $docente)
    {
        return response()->json($docente);
    }

    public function update(Request $request, $docente)
    {
        try {
            $rules = [
                'gradoacademico_id' => 'sometimes|exists:gradoacademico,id',
                'apellidos' => 'sometimes|string|max:50|regex:/^[\w\s\-]+$/u',
                'nombres' => 'sometimes|string|max:50|regex:/^[\w\s\-]+$/u',
                'genero' => 'sometimes|string|regex:/^[\w\s\-]+$/u',
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
            
            $docente = Docente::findOrFail($docente);
            
            $docente->fill($request->only(['gradoacademico_id','apellidos','nombres','genero','estado']));
            $docente->save();

            $datatable = $this->getData();

            return response()->json([
                'success' => true,
                'message' => 'Carrera actualizada con éxito',
                // 'data' => $docente
                'datatable' => $datatable
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Docente $docentes)
    {
        //
    }

    private function getData()
    {
        $docentes = Docente::where('estado', '!=', '5')->get();

        $html = "";
        foreach ($docentes as $item) {
            $id = $item->id;
            $descgradoacademico = $item->gradoacademico->descripcion;
            $nombres = $item->nombres;
            $apellidos = $item->apellidos;
            $genero = $item->genero;
            $estado = $item->estado;

            $acciones = "
            <div class='btnActionCarrera'>
                <a class='badge fw-semibold py-1 bg-primary-subtle text-primary btnEditDocente' data-id='$id' role='button'>
                    <i class='ti ti-edit'></i>                                        
                </a>
                <a class='badge fw-semibold py-1 bg-danger-subtle text-danger btnDeleteDocente' data-id='$id' role='button'>
                    <i class='ti ti-trash'></i>                                        
                </a>
            </div>
            ";

            $estado = ($estado > 0) ? 'ACTIVO' : 'INACTIVO';

            

            $genero = generoDescripcion($genero);

            $html .= "<tr>
                <td>$acciones</td>
                <td><span class='badge fw-semibold py-1 bg-primary-subtle text-primary'>$estado</span></td>
                <td>$apellidos</td>
                <td>$nombres</td>
                <td>$descgradoacademico</td>
                <td>$genero</td>
            </tr>";
        }

        return $html;
    }
    
}
