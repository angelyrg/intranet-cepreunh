<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Aulas\AulaRequest;
use App\Models\Intranet\Aula;
use App\Models\Intranet\Sede;
use App\Services\AulaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AulaController extends Controller
{
    protected $aulaService;

    public function __construct(AulaService $aulaService)
    {
        $this->aulaService = $aulaService;
    }

    public function index()
    {
        $user = Auth::user();
        if ($user->can('sedes.ver_todas')){
            $sedes = Sede::all();
        }else{
            $sedes = collect([Sede::findOrFail($user->sede_id)]);
        }
        
        $datatable = $this->getDataTable();

        $response = [
            'page' => 'Aulas',
            'title' => 'Aulas',
            'slug' => 'Aulas',
            'datatable' => $datatable,
            'sedes' => $sedes,
        ];

        return view('intranet.aulas.index')->with($response);
    }

    public function store(AulaRequest $request)
    {
        try {
            $data = $request->validated();
            $aula  = $this->aulaService->create($data);

            $dataTable = $this->getDataTable();

            return response()->json([
                'success' => true,
                'message' => 'Aula creado exitosamente.',
                'datatable' => $dataTable,
            ], 201);

        } catch (\Exception $e) {
            Log::error('Se produjo una excepción.', ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el aula.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function edit(Aula $aula)
    {
        return response()->json($aula);
    }

    public function update(AulaRequest $request, Aula $aula)
    {
        try {
            $validatedData = $request->validated();
            $result = $this->aulaService->update($aula, $validatedData);

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
        $user = Auth::user();
        $aulas = $this->aulaService->getData();

        $html = "";
        foreach ($aulas as $item) {
            $id = $item->id;
            $descripcion = $item->descripcion;
            $piso = $item->piso;
            $aforo = $item->aforo;
            $sede = $item->sede->descripcion;

            $acciones = "<div class='btnActionCarrera'>";

            if ($user->can('aula.editar')) {
                $acciones .= "<a class='btn btn-sm btn-outline-primary btnEdit' data-id='$id' role='button'>
                            <i class='ti ti-edit'></i>                                        
                        </a>";
            }

            if ($user->can('aula.eliminar')) {
                $acciones .= "<a class='btn btn-sm btn-outline-danger btnDelete' data-id='$id' role='button'>
                            <i class='ti ti-trash'></i>                                        
                        </a>";
            }

            $acciones .= "</div>";

            $html .= "<tr>
                <td>$acciones</td>
                <td>$descripcion</td>
                <td>$piso</td>
                <td>$aforo</td>
                <td>$sede</td>
            </tr>";
        }

        return $html;
    }

    public function eliminar(Aula $aula)
    {
        $result = $this->aulaService->softDelete($aula);

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
