<?php

namespace App\Http\Controllers\Api\MatriculaVirtual;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EstudianteRequest;
use App\Http\Requests\Api\ValidacionPagoRequest;
use App\Models\Common\UbigeoDepartamento;
use App\Models\Intranet\Apoderado;
use App\Models\Intranet\Area;
use App\Models\Intranet\AulaCiclo;
use App\Models\Intranet\AulaMatricula;
use App\Models\Intranet\Banco;
use App\Models\Intranet\Carrera;
use App\Models\Intranet\Ciclo;
use App\Models\Intranet\Discapacidad;
use App\Models\Intranet\EstadoCivil;
use App\Models\Intranet\Estudiante;
use App\Models\Intranet\FormaDePago;
use App\Models\Intranet\Genero;
use App\Models\Intranet\IdentidadEtnica;
use App\Models\Intranet\Matricula;
use App\Models\Intranet\Pago;
use App\Models\Intranet\Parentesco;
use App\Models\Intranet\Sede;
use App\Models\Intranet\TipoDocumento;
use App\Services\EstudianteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\MatriculaService;
use App\Services\PagoService;

use Barryvdh\DomPDF\Facade\Pdf;

class MatriculaController extends Controller
{
    protected $estudianteService;
    protected $matriculaService;
    protected $pagoService;

    public function __construct(EstudianteService $estudianteService, MatriculaService $matriculaService, PagoService $pagoService)
    {
        $this->estudianteService = $estudianteService;
        $this->matriculaService = $matriculaService;
        $this->pagoService = $pagoService;
    }

    public function validarPago(ValidacionPagoRequest $request)
    {
        try {
            $datosValidados = $request->validated();

            $dni = $datosValidados['dni'];
            $nTransaccion = $datosValidados['nTransaccion'];
            $ciclo_id = $datosValidados['ciclo'];

            // Verificar si el DNI ya ha sido matriculado
            $estudiante = Estudiante::where('nro_documento', $dni)->first();
            if ($estudiante) {
                $matriculaExistente = Matricula::where('estudiante_id', $estudiante->id)
                    ->where('ciclo_id', $ciclo_id)
                    ->where('deleted_at', null)
                    ->first();

                if ($matriculaExistente) {
                    return response()->json([
                        'success' => false,
                        'message' => 'El estudiante con el DNI proporciado ya ha sido matriculado en el ciclo seleccionado.',
                    ], 400);
                }
            }

            // Verificar si la boleta de pago existe
            $boletaConsultaResult = $this->obtenerBoletaAPI($dni, $nTransaccion);
            if (!$boletaConsultaResult['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $boletaConsultaResult['message'],
                ], 404);
            }

            $boleta = $boletaConsultaResult['data'];

            return response()->json([
                'success' => true,
                'data' => $boleta,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error en MatriculaController::validarPago: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Ocurrió un error al procesar la matrícula.'
            ];
        }
    }

    public function getFullDataByEstudiante(String $dni)
    {
        try {
            $estudiante = Estudiante::where('nro_documento', $dni)
                ->with(['matriculas', 'matriculas.pagos', 'apoderado'])
                ->first();

            $direccion_ubigeoDepartamentoId = null;
            $direccion_ubigeoProvinciaId = null;
            $nacimiento_ubigeoDepartamentoId = null;
            $nacimiento_ubigeoProvinciaId = null;
            $colegio_ubigeoDepartamentoId = null;
            $colegio_ubigeoProvinciaId = null;

            // Ubigeo DIRECCION
            $direccion_ubigeo = $estudiante->direccion_ubigeodistrito_id ?? null;
            if ($direccion_ubigeo) {
                $direccion_ubigeoDepartamentoId = substr($direccion_ubigeo, 0, 2);
                $direccion_ubigeoProvinciaId = substr($direccion_ubigeo, 0, 4);
            }

            // Ubigeo NACIMIENTO
            $nacimiento_ubigeo = $estudiante->nacimiento_ubigeodistrito_id ?? null;
            if ($nacimiento_ubigeo) {
                $nacimiento_ubigeoDepartamentoId = substr($nacimiento_ubigeo, 0, 2);
                $nacimiento_ubigeoProvinciaId = substr($nacimiento_ubigeo, 0, 4);
            }

            // Ubigeo COLEGIO
            $colegio_ubigeo = $estudiante->colegio_ubigeodistrito_id ?? null;
            if ($colegio_ubigeo) {
                $colegio_ubigeoDepartamentoId = substr($colegio_ubigeo, 0, 2);
                $colegio_ubigeoProvinciaId = substr($colegio_ubigeo, 0, 4);
            }

            $tipos_documentos = TipoDocumento::all();
            $generos = Genero::all();
            $estados_civiles = EstadoCivil::all();
            $discapacidades = Discapacidad::all();
            $identidades_etnicas = IdentidadEtnica::all();
            $parentescos = Parentesco::all();
            $departamentos = UbigeoDepartamento::all();


            $data = [
                'estudiante' => $estudiante,
                
                'tipos_documentos' => $tipos_documentos,
                'generos' => $generos,
                'estados_civiles' => $estados_civiles,
                'discapacidades' => $discapacidades,
                'identidades_etnicas' => $identidades_etnicas,
                'parentescos' => $parentescos,
                'departamentos' => $departamentos,

                'direccion_ubigeoDepartamentoId' => $direccion_ubigeoDepartamentoId,
                'direccion_ubigeoProvinciaId' => $direccion_ubigeoProvinciaId,
                'nacimiento_ubigeoDepartamentoId' => $nacimiento_ubigeoDepartamentoId,
                'nacimiento_ubigeoProvinciaId' => $nacimiento_ubigeoProvinciaId,
                'colegio_ubigeoDepartamentoId' => $colegio_ubigeoDepartamentoId,
                'colegio_ubigeoProvinciaId' => $colegio_ubigeoProvinciaId,

            ];

            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error en MatriculaController::getFullDataByEstudiante: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Ocurrió un error al obtener estudiante.'
            ];
        }
    }

    public function getFullDataByUUID(String $uuid)
    {
        try {
            $matricula = Matricula::where('uuid', $uuid)
                ->where('estado', 1)
                ->with(['estudiante', 'ciclo', 'pagos'])
                ->first();

            if (!$matricula) {
                return response()->json([
                    'success' => false,
                    'message' => 'Matrícula no encontrada',
                ], 404);
            }

            $tipos_documentos = TipoDocumento::all();
            $generos = Genero::all();
            $estados_civiles = EstadoCivil::all();
            $discapacidades = Discapacidad::all();
            $identidades_etnicas = IdentidadEtnica::all();
            $departamentos = UbigeoDepartamento::all();

            $data = [
                'matricula' => $matricula,
                'tipos_documentos' => $tipos_documentos,
                'generos' => $generos,
                'estados_civiles' => $estados_civiles,
                'discapacidades' => $discapacidades,
                'identidades_etnicas' => $identidades_etnicas,
                'ubigeos_departamentos' => $departamentos,
            ];

            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error en MatriculaController::getByUUID: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Ocurrió un error al obtener la matrícula.'
            ];
        }
    }

    public function obtenerBoletaAPI($dni, $nTransaccion)
    {
        $data = [
            "t_dni" => $dni,
            "nTransaccion" => $nTransaccion
        ];

        $COD_OPERACION_PAGOS_CEPRE = ['2701', '2700', '2699'];

        try {
            $response = Http::asForm()->post('https://sisacad2.unh.edu.pe/apis/api_login/api_caja.php', $data);

            if (!$response->successful()) {
                return [
                    'success' => false,
                    'message' => 'Error en la solicitud a la API externa.',
                ];
            }

            $responseData = $response->json();

            if ($responseData['status'] !== 'ok') {
                return [
                    'success' => false,
                    'message' => 'No se encontraron resultados en la API.',
                ];
            }

            // TODO:Validar que el pago ingresado sea del pago de matrícula           
            $filteredData = collect($responseData['result'])->first(function ($item) use ($dni, $nTransaccion) {
                return $item['DNI'] === $dni && ltrim($item['Transaccion'], '0') === ltrim($nTransaccion, '0'); //ltrim(): Quita los ceros del inicio
            });

            // if( !in_array($filteredData['CodigoOperacion'], $COD_OPERACION_PAGOS_CEPRE) ){                
            // }

            if ($filteredData) {
                return [
                    'success' => true,
                    'data' => $filteredData,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'No se encontró ninguna boleta con el DNI y número de transacción proporcionado.',
                ];
            }
        } catch (\Exception $e) {
            Log::error('Error en MatriculaController::obtenerBoletaAPI: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Ocurrió un error al obtener la boleta.'
            ];
        }
    }

    public function updateDatosEstudiante(EstudianteRequest $request, Estudiante $estudiante)
    {
        try {
            $validatedData = $request->validated();
            $estudiante->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Datos del estudiante actualizados correctamente.',
                'data' => $estudiante
            ]);
        } catch (\Exception $e) {
            Log::error('Error en MatriculaController::updateDatosEstudiante: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Ocurrió un error al guardar la información del estudiante.'
            ];
        }
    }

    public function getDataForMatricula($ciclo_id)
    {
        try {
            $areas = Area::all();
            $carreras = Carrera::all();
            $sedes = Sede::all();
            $bancos = Banco::all();
            $formasDePago = FormaDePago::all();

            $ciclo = Ciclo::with(['precios.forma_de_pago'])->findOrFail($ciclo_id);

            $aulaCicloDisponibles = AulaCiclo::with('aula')
            ->where('ciclo_id', $ciclo->id)
            ->has('aula')
            ->get();

            // ASIGNACION DE AULAS AUTOMÁTICO EN MATRIACULA VIRTUAL
            // Iterar sobre los resultados y agregar el campo 'full' si el aforo ha sido alcanzado
            $aulaCicloDisponibles->each(function ($aulaCiclo) {
                $aforo = $aulaCiclo->aula->aforo;
                $matriculasExistentes = AulaMatricula::where('aula_ciclo_id', $aulaCiclo->id)->count();
                $aulaCiclo->full = $matriculasExistentes >= $aforo;
            });

            $modalidades_estudio = Matricula::MODALIDADES_ESTUDIO;
            $condiciones_academicas = Matricula::CONDICIONES_ACADEMICAS;

            $data = [
                'ciclo' => $ciclo,
                'aulaCicloDisponibles' => $aulaCicloDisponibles,
                'areas' => $areas,
                'carreras' => $carreras,
                'sedes' => $sedes,
                'bancos' => $bancos,
                'formasDePago' => $formasDePago,
                'modalidades_estudio' => $modalidades_estudio,
                'condiciones_academicas' => $condiciones_academicas,
            ];

            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error en Api/MatriculaController::getDataForMatricula: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Ocurrió un error al datos para la matricula.'
            ];
        }
        

        
    }

    public function guardarMatriculaVirtual(Request $request){
        try {
            $ciclo_id = $request->input('ciclo_id');
            $estudianteData = $request->input('estudiante');
            $matriculaData = $request->input('matricula');
            $boletaData = $request->input('boleta');

            $estudiante = Estudiante::where('nro_documento', $estudianteData['nro_documento'])->first();

            $datosApoderado = [
                'telefono_apoderado' => $estudianteData['telefono_apoderado'],
                'correo_apoderado' => $estudianteData['correo_apoderado'],
                'parentesco_id' => $estudianteData['parentesco_id'],
            ];

            if ($estudiante){
                $apoderado = $estudiante->apoderado()->first();
                if ($apoderado) {
                    $apoderado->telefono_apoderado = $datosApoderado['telefono_apoderado'];
                    $apoderado->correo_apoderado = $datosApoderado['correo_apoderado'];
                    $apoderado->parentesco_id = $datosApoderado['parentesco_id'];
                    $apoderado->save();
                } else {
                    $apoderado = Apoderado::create($datosApoderado);
                }
            }else{
                $apoderado = Apoderado::create($datosApoderado);
            }

            $dataEstudianteToSave = [
                'tipo_documento_id' => $estudianteData['tipo_documento_id'],
                'nro_documento' => $estudianteData['nro_documento'],
                'nombres' => $estudianteData['nombres'],
                'apellido_paterno' => $estudianteData['apellido_paterno'],
                'apellido_materno' => $estudianteData['apellido_materno'],
                'genero_id' => $estudianteData['genero_id'],
                'estado_civil_id' => $estudianteData['estado_civil_id'],
                'fecha_nacimiento' => $estudianteData['fecha_nacimiento'],
                'pais_nacimiento' => $estudianteData['pais_nacimiento'],
                'nacionalidad' => $estudianteData['nacionalidad'],
                'telefono_personal' => $estudianteData['telefono_personal'],
                'whatsapp' => $estudianteData['whatsapp'],
                'correo_personal' => $estudianteData['correo_personal'],
                'correo_institucional' => $estudianteData['correo_institucional'],
                'tiene_discapacidad' => $estudianteData['tiene_discapacidad'],
                //dispacidades
                'identidad_etnica_id' => $estudianteData['identidad_etnica_id'],
                'nacimiento_ubigeodistrito_id' => $estudianteData['nacimiento_ubigeodistrito_id'],
                'direccion_ubigeodistrito_id' => $estudianteData['direccion_ubigeodistrito_id'],
                'direccion' => $estudianteData['direccion'],

                'colegio_ubigeodistrito_id' => $estudianteData['colegio_ubigeodistrito_id'],
                'colegio_id' => $estudianteData['colegio_id'],
                'year_culminacion' => $estudianteData['year_culminacion'],

                'apoderado_id' => $apoderado->id,
                'sede_actual_id' => $matriculaData['sede_id'],
            ];

            // Si no se encuentra 'estudiante', retornamos un error adecuado
            if (is_null($estudianteData)) {
                return response()->json(['message' => 'No hay estudiante'], 400);
            }

            // Verificamos si 'nro_documento' existe en 'estudiante'
            if (!isset($estudianteData['nro_documento'])) {
                return response()->json(['message' => 'Número de documento del estudiante no proporcionado'], 400);
            }
            
            if ($estudiante) {
                $estudiante = $this->estudianteService->update($estudiante, $dataEstudianteToSave);
            }else{
                $estudiante = $this->estudianteService->create($dataEstudianteToSave);
            }

            if (!$estudiante) {
                throw new \Exception('No se encontró ningún estudiante para matricular.');
            }


            $estudiante->load('matriculas');
            $cantidad_matriculas = $estudiante->matriculas->count() + 1;

            $aulaDisponible = $this->obtenerAulaDisponible($matriculaData['sede_id'], $ciclo_id, $matriculaData['area_id']);

            if (!$aulaDisponible) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay aulas disponibles para matricular al estudiante. Por favor, contacte con el administrador.'
                ]);
            }

            $dataMatriculaToSave = [
                'ciclo_id' => $ciclo_id,
                'estudiante_id' => $estudiante->id,
                'area_id' => $matriculaData['area_id'],
                'carrera_id' => $matriculaData['carrera_id'],
                'sede_id' => $matriculaData['sede_id'],
                'modalidad_estudio' => $matriculaData['modalidad_estudio'],
                'condicion_academica' => $matriculaData['condicion_academica'],
                'cantidad_matricula' => $cantidad_matriculas,
                'aula_ciclo_actual_id' => $aulaDisponible->id,
                'modalidad_matricula' => 2, //1: Presencial, 2: Virtual
            ];

            $matricula = $this->matriculaService->create($dataMatriculaToSave);

            $dataPagoToSave = [
                'matricula_id' => $matricula->id,
                'banco_id' => $matriculaData['banco_id'],
                'cod_operacion' => $boletaData['cod_operacion'],
                'descripcion_pago' => $boletaData['descripcion_pago'],
                'n_transaccion' => $boletaData['nro_transaccion'],
                'monto' => $boletaData['monto'],
                'comision' => $boletaData['comision'],
                'monto_neto' => $boletaData['monto_neto'],
                'condicion_pago' => $matriculaData['condicion_pago'],
                'fecha_pago' => $boletaData['fecha_pago'],
                'forma_de_pago_id' => $matriculaData['forma_de_pago_id']
            ];

            $pago = $this->pagoService->create($dataPagoToSave);


            $aula = AulaMatricula::create([
                'matricula_id' => $matricula->id,
                'aula_ciclo_id' => $aulaDisponible->id,
            ]);

            if ($estudiante && $matricula && $pago && $aula)
            {
                return response()->json([
                    'success' => true,
                    'message' => 'Estudiante matriculado correctamente.',
                    'matricula' => $matricula->uuid
                ]);

            }else{
                if ($aula){
                    $aula->delete();
                }
                if ($pago){
                    $this->pagoService->forceDelete($pago);
                }
                if ($matricula){
                    $this->matriculaService->forceDelete($matricula);
                }
            }

        }catch (\Exception $e) {
            Log::error('Error en Api/MatriculaController::guardarMatricula: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Ocurrió un error al datos al realizar la matricula. Ponte en contacto con el admintrador para obtener ayuda.'
            ];
        }
    }

    public function descargarFichaDeMatriculaVirtual($uuid)
    {
        try {
            $matriculaData = $this->matriculaService->getMatriculaDataToPrint($uuid);

            // Si hubo un problema al obtener los datos, devolver el error con el código correspondiente
            if (!$matriculaData['success']) {
                return response()->json([
                    'message' => $matriculaData['message'],
                    'error' => $matriculaData['error'] ?? 'Detalles del error no disponibles.',
                ], $matriculaData['code']);
            }

            // Generar el PDF de la matrícula
            $pdf = PDF::loadView('intranet.matricula.descargar_pdf', [
                'matricula' => $matriculaData['matricula'],
                'unh_logo' => $matriculaData['unh_logo_icon'],
                'document_header' => $matriculaData['document_header_img']
            ])->setPaper('A4', 'portrait');

            // Devolver el PDF como una descarga
            return response()->stream(function () use ($pdf) {
                echo $pdf->output();
            }, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="FICHA_DE_MATRICULA_VIRTUAL.pdf"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Hubo un problema al procesar la solicitud.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function obtenerAulaDisponible($sede, $ciclo, $area)
    {
        $aulaCicloDisponible = AulaCiclo::with('aula')
            ->where('area_id', $area)
            ->where('ciclo_id', $ciclo)
            ->whereHas('aula', function ($query) use ($sede) {
                $query->where('sede_id', $sede);
            })
            ->get()
            ->filter(function ($aulaCiclo) {
                $aforo = $aulaCiclo->aula->aforo;
                $matriculasExistentes = AulaMatricula::where('aula_ciclo_id', $aulaCiclo->id)->count();
                return $matriculasExistentes < $aforo;
            })
            ->first();

        return $aulaCicloDisponible;
    }


    public function getFichaDeMatriculaByEstudiante($dni, $ciclo_id)
    {

        try {
            $estudiante = $this->estudianteService->getEstudianteByNroDocumento($dni);

            if (!$estudiante) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo encontrar al estudiante con el DNI proporcionado.',
                ], 404);
            }

            $matricula = $this->matriculaService->getMatriculasByColumns(['estudiante_id' => $estudiante->id, 'ciclo_id' => $ciclo_id], true);

            if (!$matricula) {
                return response()->json([
                    'success' => false,
                    'message' => 'El estudiante no tiene matrícula registrada en el ciclo seleccionado.',
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Ficha de matrícula encontrada.',
                'data' => $matricula
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hubo un problema al buscar la ficha de matricula.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
