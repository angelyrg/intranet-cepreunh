<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use App\Models\Intranet\Area;
use App\Models\intranet\Carrera;
use App\Models\Intranet\CarreraCiclo;
use App\Models\Intranet\Ciclo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CarreraCicloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $dataCiclo = Ciclo::all();
        $idCicloDefault = $this->getDefaultCiclo();

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

        
        
        $sltCarreras = ($idCicloDefault)?$this->getCarreraSelect($idCicloDefault):'';
        $bloqueArea = ($idCicloDefault)?$this->getBloqueArea($idCicloDefault):'';
        $datatable = "";

        $response = [
            'page' => 'CarreraCiclo',
            'title' => 'Carreraciclo',
            'datatable' => $datatable,
            'sltCarreras' => $sltCarreras,
            'bloqueArea' => $bloqueArea,
            'sltCicloAcademico' => $sltCicloAcademico,
        ];

        return view('intranet.asignaciones.carrera')->with($response);

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

        

        $validator = Validator::make($request->all(),
        [
            'carrera_id' => 'required',
        ],
        [
            'carrera_id.required' => ' Seleccione una carrera',
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

            $estadoCarreraCiclo = 1;
            foreach ($request->carrera_id as $value) {

                log::info('$ request->carrera_id ==> ', $request->carrera_id);

                $id = $value;

                // log::info('data id ==> ', $id);

                CarreraCiclo::create([
                    'ciclo_id' => $request->ciclo_id,
                    'carrera_id' => $id,
                    'estado' => $estadoCarreraCiclo
                ]);

                // CarreraCiclo::create($request->only(['ciclo_id','carrera_id','estado']));

            }


            $bloqueArea = $this->getBloqueArea($request->ciclo_id);
            $sltCarreras = $this->getCarreraSelect($request->ciclo_id);

            return response()->json([
                'success' => true,
                'message' => 'Carrera asignada al ciclo correctamente',
                'datatable' => $bloqueArea,
                'sltCarreras' => $sltCarreras,
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

    /**
     * $id => idCiclo
     */
    public function carreras(Request $request){ 
        
        log::info("data ====>",$request->all());

        $idCiclo = $request->all();

        $dataCarreraCiclo = CarreraCiclo::where('ciclo_id','=',$idCiclo)->get();
        $bloqueArea = $this->getBloqueArea($idCiclo);
        $sltCarreras = $this->getCarreraSelect($idCiclo);

        $response = [
            'success' => true,
            'message' => 'Cambiando ciclo académico',
            'dataCarreraCiclo' => $dataCarreraCiclo,
            'sltCarreras' => $sltCarreras,
            'datatable' => $bloqueArea,
        ];
        return $response;

    }

    private function getDefaultCiclo(){
        $dataArea = Ciclo::where('estado','=','1')->orderBy('id','desc')->limit(1)->get();
        return ($dataArea)?$dataArea[0]['id']:0;

    }

    private function getCarreraSelect($idCiclo){

        $dataArea = Area::where('estado','!=','5')->get();

        $html = "";
        foreach ($dataArea as $item) {
            $html .= "<optgroup label='{$item->descripcion}'>";
        
            foreach ($item->carreras as $carrera) {
                $id = $carrera->id;
                $descareas = $carrera->area->descripcion;
                $descripcion = $carrera->descripcion;

                $dataArea = CarreraCiclo::where('estado','!=','5')->where('carrera_id','=',$id)->where('ciclo_id','=',$idCiclo)->get(); 

                $idcarreraciclo = (count($dataArea) > 0)?$dataArea[0]['id']:0;

                $textColor = ($idcarreraciclo > 0)?'check text-success':'';
                $textDisabled = ($idcarreraciclo > 0)?'disabled':'';
                $textTitle = ($idcarreraciclo > 0)?'Carrera asignada':'Carrera sin asignada';
                        
                $html .= "<option value='$id' data-flag='$textColor fs-4' title='$textTitle' $textDisabled > $descareas - $descripcion $idcarreraciclo</option>";
            }
        
            $html .= "</optgroup>";
        }

        return $html;

    }

    public function eliminar(Request $request, $id)
    {
        $selectedValues = $request->input('selectedValues');
        
        $arrayCarreraCiclo = json_decode($selectedValues, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json([
                'success' => false,
                'message' => 'Datos JSON inválidos'
            ], 400);
        }
        
        $deleted_status = 5;
        
        try {

            $idCiclo = $request->ciclo_id;
            
            
            foreach ($arrayCarreraCiclo as $key => $value) {
                $id = $value['id'];
                $Carreraciclo = CarreraCiclo::find($id);

                if ($Carreraciclo){
                    $Carreraciclo->estado = $deleted_status;
                    $Carreraciclo->save();
                    
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Carrera no encontrada'
                    ], 404);
                }

            }            
            
            $datatable = $this->getBloqueArea($idCiclo);
            $sltCarreras = $this->getCarreraSelect($idCiclo);

            return response()->json([
                'success' => true,
                'message' => 'Asignatura eliminada con éxito',
                'datatable' => $datatable,
                'sltCarreras' => $sltCarreras,
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
        
    public function eliminar2(CarreraCiclo $Carreraciclo)
    {

        Log::info('datos de form ==> ', json_decode($Carreraciclo,true));
        Log::info('datos de form ==> ', ($Carreraciclo->id));

        $deleted_status = 5; //Estado 5 significa eliminado
        try {
            $Carreraciclo->estado = $deleted_status;
            $Carreraciclo->save();

            $datatable = $this->getBloqueArea();
            $sltCarreras = $this->getCarreraSelect();

            return response()->json([
                'success' => true,
                'message' => 'Asignatura eliminada con éxito',
                'datatable' => $datatable,
                'sltCarreras' => $sltCarreras,
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

    private function getBloqueArea($idCiclo){

        $dataAreas = Area::where('estado','REGEXP','^[^5]')->get();

        // $dataCarrera = Carrera::where('estado','REGEXP','^[^5]')->get();
        $html = "";

        foreach ($dataAreas as $key => $item) {
            $id = $item['id'];
            $descripcion = $item['descripcion'];            

            $html .= "
            <div class='col'>
                <table class='table table-bordered border text-nowrap m-1 align-middle' id='tblAreaCiclo_$id'>
                    <thead class='text-dark fs-4'>
                        <tr>
                            <th class='bg-light text-center' style='width: 10%;'>
                                <div class='btnActionCarrera badge py-1 btn bg-info-subtle'>
                                    <a class='mx-auto my-auto' title='Seleccionar toda las carreras'>
                                        <input type='checkbox' class='form-check-input btnRemoveCarreraAll inputCarrera$id' data-idarea='$id' data-chkall='1' value='check'>                                        
                                    </a>
                                    <span class='badge btn bg-danger-subtle text-danger ms-2 btnDeleteCarreraCiclo' data-id='$id' title='Remover carreras seleccionadas' style='display:none'>
                                        <i class='ti ti-trash my-1 mx-auto'></i>
                                    </span>
                                </div>
                            </th>
                            <th class='bg-light'>
                                <h6 class='fs-4 fw-semibold'>$descripcion</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody>                   
            ";

            $dataCarreras = DB::table('carrera_ciclo')
            ->join('carreras', 'carreras.id', '=', 'carrera_ciclo.carrera_id')
            ->select('carrera_ciclo.*', 'carreras.descripcion as desccarrera')
            ->where('carreras.estado','REGEXP','^[^5]')
            ->where('carrera_ciclo.estado','REGEXP','^[^5]')
            ->where('carreras.area_id','=',$id)
            ->where('carrera_ciclo.ciclo_id','=',$idCiclo)
            ->get();

            if(count($dataCarreras) > 0){
                foreach ($dataCarreras as $key => $value) {
                    $idCarreraCiclo = $value->id;
                    // $descareas = $value->area->descripcion;
                    $desccarrera = $value->desccarrera;
    
                    $acciones = "
                    <div class='btnActionCarrera'>
                        <a class='badge fw-semibold py-1 btn bg-danger-subtle text-danger' data-id='$idCarreraCiclo' role='button'>
                            <i class='ti ti-trash'></i>                                        
                        </a>
                    </div>
                    ";
        
                    $html .= "<tr>
                                <td class='text-center' title='Seleccionar'>
                                    <input type='checkbox' name='carreraciclo[]' name='$idCarreraCiclo' class='form-check-input me-1 btnRemoveCarrera inputCarrera$id' data-id='$idCarreraCiclo' data-idarea='$id' data-chkall='0' value='check'>
                                </td>
                                <td>$desccarrera</td>
                            </tr>
                            ";
        
                }
            }else{
                $html .= "<tr><td colspan='2'><i>No hay carreras asignadas</i></td></tr>";
            }
            

            $html .= "</tbody></table></div>";
        }
        

        return $html;

    }

}
