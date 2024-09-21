<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Intranet\Sedes\SedeRequest;
use App\Models\Intranet\Sede;
use App\Services\SedeService;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    protected $sedeService;

    public function __construct(SedeService $sedeService)
    {
        $this->sedeService = $sedeService;
    }

    public function index()
    {
        $datatable = $this->getDataTable();

        $response = [
            'page' => 'Sedes',
            'title' => 'Sedes',
            'slug' => 'Sedes',
            'datatable' => $datatable,
        ];

        return view('intranet.sedes.index')->with($response);
    }

    public function store(SedeRequest $request)
    {
        try {
            $data = $request->validated();
            $sede  = $this->sedeService->create($data);

            $dataTable = $this->getDataTable();

            return response()->json([
                'success' => true,
                'message' => 'Sede creado exitosamente.',
                'datatable' => $dataTable,
            ], 201);

        } catch (\Exception $e) {
            Log::error('Se produjo una excepción.', ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la sede.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function edit(Sede $sede)
    {
        return response()->json($sede);
    }

    public function update(SedeRequest $request, Sede $sede)
    {
        try {
            $validatedData = $request->validated();
            $result = $this->sedeService->update($sede, $validatedData);

            $datatable = $this->getDataTable();

            return response()->json([
                'success' => true,
                'message' => 'Sede actualizado con éxito',
                'datatable' => $datatable
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la sede',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    private function getDataTable()
    {
        $sedes = $this->sedeService->getData();

        $html = "";
        foreach ($sedes as $item) {
            $id = $item->id;
            $descripcion = $item->descripcion;
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
                <td>$fecha_creacion</td>
            </tr>";
        }

        return $html;
    }

    public function eliminar(Sede $sede)
    {
        $result = $this->sedeService->softDelete($sede);

        if ($result['success']) {
            $datatable = $this->getDataTable();

            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'datatable' => $datatable
            ], $result['code']);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
            'error' => $result['error'] ?? null
        ], $result['code']);
    }
}
