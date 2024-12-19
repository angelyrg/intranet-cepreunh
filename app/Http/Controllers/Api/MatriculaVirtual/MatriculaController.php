<?php

namespace App\Http\Controllers\Api\MatriculaVirtual;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EstudianteRequest;
use App\Http\Requests\Api\ValidacionPagoRequest;
use App\Models\Common\UbigeoDepartamento;
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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MatriculaController extends Controller
{
    public function validarPago(ValidacionPagoRequest $request)
    {
        try {
            $datosValidados = $request->validated();

            $dni = $datosValidados['dni'];
            $nTransaccion = $datosValidados['nTransaccion'];
            $ciclo_id = $datosValidados['ciclo'];

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
            Log::error('Error en MatriculaController::procesarMatricula: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Ocurrió un error al procesar la matrícula.'
            ];
        }
    }

    public function procesarMatricula(ValidacionPagoRequest $request)
    {
        try {
            $datosValidados = $request->validated();

            $dni = $datosValidados['dni'];
            $nTransaccion = $datosValidados['nTransaccion'];
            $ciclo_id = $datosValidados['ciclo'];

            // Verificar si la boleta de pago existe
            $boletaConsultaResult = $this->obtenerBoletaAPI($dni, $nTransaccion);
            if (!$boletaConsultaResult['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $boletaConsultaResult['message'],
                ], 404);
            }

            $boleta = $boletaConsultaResult['data'];

            // Buscar o crear estudiante por su DNI
            $estudiante = Estudiante::firstOrCreate(
                ['nro_documento' => $dni, 'tipo_documento_id' => 1] //1:DNI
            );

            // Verificar si el estudiante ya está matriculado en el ciclo y si no, lo crea
            $matricula = Matricula::firstOrCreate([
                'ciclo_id' => $ciclo_id,
                'estudiante_id' => $estudiante->id,
            ]);

            if ($matricula->wasRecentlyCreated) {
                $pago = Pago::create([
                    'matricula_id' => $matricula->id,
                    'banco' => $boleta['Banco'],
                    'cod_operacion' => $boleta['CodigoOperacion'],
                    'descripcion_pago' => $boleta['DescripcionPago'],
                    'fecha_pago' => $boleta['FechaOperacion'] . " " . $boleta['HoraOperacion'],
                    'n_transaccion' => $boleta['Transaccion'],
                    'monto' => $boleta['monto'],
                    'comision' => $boleta['comision'],
                    'monto_neto' => $boleta['monto_neto'],
                ]);
            }

            return response()->json([
                'success' => true,
                'uuid' => $matricula->uuid,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error en MatriculaController::procesarMatricula: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Ocurrió un error al procesar la matrícula.'
            ];
        }
    }

    public function getByUUID(String $uuid)
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

            return response()->json([
                'success' => true,
                'data' => $matricula,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error en MatriculaController::getByUUID: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Ocurrió un error al obtener la matrícula.'
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
                return $item['DNI'] === $dni && $item['Transaccion'] === $nTransaccion;
            });

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
}
