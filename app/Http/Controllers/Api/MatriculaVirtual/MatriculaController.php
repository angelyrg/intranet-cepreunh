<?php

namespace App\Http\Controllers\Api\MatriculaVirtual;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ValidacionPagoRequest;
use App\Models\Intranet\Estudiante;
use App\Models\Intranet\Matricula;
use App\Models\Intranet\Pago;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MatriculaController extends Controller
{
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
                ['nro_documento' => $dni, 'tipo_documento' => 'DNI']
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
                'matricula' => $matricula,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error en MatriculaController::procesarMatricula: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Ocurrió un error al procesar la matrícula.'
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
                    'message' => 'No se encontró ninguna boleta con el número de transacción proporcionado.',
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

}
