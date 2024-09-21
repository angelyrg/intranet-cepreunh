<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use App\Models\Intranet\Area;
use App\Models\Intranet\Asignatura;
use App\Models\Intranet\AsignaturaCiclo;
use App\Models\Intranet\CarreraCiclo;
use App\Models\Intranet\Ciclo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AsignaturaCicloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ciclo = new Ciclo();
        $idCicloDefault = $ciclo->getDefaultCiclo();

        log::info('infooo ==> ', [$idCicloDefault]);

        $dataCiclo = Ciclo::all();

        $sltCicloAcademico = '';
        foreach ($dataCiclo as $key => $value) {
            $id = $value['id'];
            $descripcion = $value['descripcion'];
            $fechainicio = date('d/m/Y', strtotime($value['fecha_inicio']));
            $fechafinal = date('d/m/Y', strtotime($value['fecha_fin']));
            $fechafin = $value['fecha_fin'];
            $duracion = $value['duracion'];

            $selected = ($id == $idCicloDefault)?'selected':'';

            $sltCicloAcademico .= "<option value='$id' $selected>$descripcion | $fechainicio - $fechafinal | $duracion semanas</option>";
        }
        

        $sltAsignaturas = $idCicloDefault ? $this->getAsignaturaSelect($idCicloDefault) : '';
        
        $bloqueArea = ($idCicloDefault)?$this->getBloqueArea($idCicloDefault):'';

        $datatable = "";
        $response = [
            'page' => 'asignaturaciclo',
            'title' => 'AsignaturaCiclo',
            'descripcion' => 'Asignación de asignaturas',
            'datatable' => $datatable,
            'sltAsignaturas' => $sltAsignaturas,
            'bloqueArea' => $bloqueArea,
            'sltCicloAcademico' => $sltCicloAcademico,
        ];

        return view('intranet.asignaciones.asignatura')->with($response);
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

        Log::info('data -->c', $request->all());

        $validator = Validator::make($request->all(),
        [
            'asignatura_id' => 'required',
        ],
        [
            'asignatura_id.required' => ' Seleccione una carrera',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 422);
        }

        

        try {

            $params = $request->all();

            
            
            // print_r($request->input('ciclo_id'));

            $estadoAsignaturaCiclo = 1;
            foreach ($request->asignatura_id as $value) {

                log::info('$ request->asignatura_id ==> ', $request->asignatura_id);

                $id = $value;

                // log::info('data id ==> ', $id);

                AsignaturaCiclo::create([
                    'ciclo_id' => $request->ciclo_id,
                    'asignatura_id' => $id,
                    'estado' => $estadoAsignaturaCiclo
                ]);

                // CarreraCiclo::create($request->only(['ciclo_id','asignatura_id','estado']));

            }


            $bloqueArea = $this->getBloqueArea($request->ciclo_id);
            $sltAsignatura = $this->getAsignaturaSelect($request->ciclo_id);

            return response()->json([
                'success' => true,
                'message' => 'Carrera asignada al ciclo correctamente',
                'datatable' => $bloqueArea,
                'sltAsignatura' => $sltAsignatura,
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function eliminar(Request $request, $id)
    {
        $selectedValues = $request->input('selectedValues');
        
        $arrayAsignaturaCiclo = json_decode($selectedValues, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json([
                'success' => false,
                'message' => 'Datos JSON inválidos'
            ], 400);
        }
        
        $deleted_status = 5;
        
        try {

            $idCiclo = $request->ciclo_id;
            
            
            foreach ($arrayAsignaturaCiclo as $key => $value) {
                $id = $value['id'];
                $Carreraciclo = CarreraCiclo::find($id);

                if ($Carreraciclo){
                    $Carreraciclo->estado = $deleted_status;
                    $Carreraciclo->save();
                    
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Asignatura no encontrada'
                    ], 404);
                }

            }            
            
            $datatable = $this->getBloqueArea($idCiclo);
            $sltAsignaturas = $this->getAsignaturaSelect($idCiclo);

            return response()->json([
                'success' => true,
                'message' => 'Asignatura eliminada con éxito',
                'datatable' => $datatable,
                'sltAsignaturas' => $sltAsignaturas,
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Asignatura no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la asignatura',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function asignaturas(Request $request){ 
        
        Log::info("data ====>",$request->all());

        $params = $request->all();
        $idCiclo = $params['id'];

        $dataCarreraCiclo = CarreraCiclo::where('ciclo_id','=',$idCiclo)->get();
        $sltAsignaturas = $this->getAsignaturaSelect($idCiclo);
        $bloqueArea = $this->getBloqueArea($idCiclo);

        $response = [
            'success' => true,
            'message' => 'Cambiando ciclo académico',
            'dataCarreraCiclo' => $dataCarreraCiclo,
            'sltAsignaturas' => $sltAsignaturas,
            'datatable' => $bloqueArea,
        ];
        return $response;

    }


    private function getAsignaturaSelect($idCiclo){

        $dataAsignatura = Asignatura::all();

        $html = "";
        
            foreach ($dataAsignatura as $asignatura) {
                $id = $asignatura->id;
                $descripcion = $asignatura->descripcion;

                $dataArea = AsignaturaCiclo::where('asignatura_id','=',$id)->where('ciclo_id','=',$idCiclo)->get(); 

                Log::info("id ====> ", [$id]);
                
                
                $idasignaturaciclo = (count($dataArea) > 0)?$dataArea[0]['id']:0;
                Log::info("idasignaturaciclo ====> ", [$idasignaturaciclo]);
                
                $textColor = ($idasignaturaciclo > 0)?'check text-success':'';
                Log::info("textColor ====> ", [$textColor]);
                $textDisabled = ($idasignaturaciclo > 0)?'disabled':'';
                $textTitle = ($idasignaturaciclo > 0)?'Asignatura asignada':'Asignatura sin asignada';
                        
                $html .= "<option value='$id' data-flag='$textColor fs-4' title='$textTitle' $textDisabled > $descripcion</option>";
            }

        return $html;

    }

    private function getBloqueArea($idCiclo){

        $html = "";

            $dataAsignatura = DB::table('asignatura_ciclo')
            ->join('asignaturas', 'asignaturas.id', '=', 'asignatura_ciclo.asignatura_id')
            ->select('asignatura_ciclo.*', 'asignaturas.descripcion as descasignatura')
            ->where('asignaturas.estado','=','1')
            ->where('asignatura_ciclo.estado','=','1')
            // ->where('asignaturas.area_id','=',$id)
            ->where('asignatura_ciclo.ciclo_id','=',$idCiclo)
            ->get();

            
            if(count($dataAsignatura) > 0){
                foreach ($dataAsignatura as $key => $value) {
                    Log::alert('dataAsignaturaz ===> ', [$value->id]);
                    $idAsignaturaCiclo = $value->id;
                    // $descareas = $value->area->descripcion;
                    $descasignatura = $value->descasignatura;
    
                    $acciones = "
                    <div class='btnActionAsignatura'>
                        <a class='badge fw-semibold py-1 btn bg-danger-subtle text-danger' data-id='$idAsignaturaCiclo' role='button'>
                            <i class='ti ti-trash'></i>                                        
                        </a>
                    </div>
                    ";
        
                    $html .= "<tr>
                                <td class='text-center' title='Seleccionar'>
                                    <input type='checkbox' name='asignaturaciclo[]' name='$idAsignaturaCiclo' class='form-check-input me-1 btnRemoveAsignatura inputAsignatura' data-id='$idAsignaturaCiclo' data-chkall='0' value='check'>
                                </td>
                                <td>$descasignatura</td>
                            </tr>
                            ";
        
                }
            }else{
                $html .= "<tr><td colspan='2'><i>No hay asignaturas asignadas</i></td></tr>";
            }

            Log::info('dataaaa ===> ' , [$html]);
        

        return $html;

    }

}
