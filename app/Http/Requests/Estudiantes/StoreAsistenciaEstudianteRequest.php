<?php

namespace App\Http\Requests\Estudiantes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAsistenciaEstudianteRequest  extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'matricula_id' => [
                'required',
                'exists:matriculas,id',
                function ($attribute, $value, $fail) {
                    $fechaEntrada = $this->input('entrada');
                    $fechaEntradaFormateada = date('Y-m-d', strtotime($fechaEntrada));
                    $yaRegistrado = DB::table('asistencias')
                    ->where('matricula_id', $value)
                    ->whereDate('entrada', $fechaEntradaFormateada)
                        ->exists();

                    if ($yaRegistrado) {
                        $fail('Ya se ha registrado la asistencia para esta fecha.');
                    }
                },
            ],
            'estudiante_id' => 'required|exists:estudiantes,id',
            'ciclo_id' => 'required|exists:ciclos,id',
            'sede_id' => 'required|exists:sedes,id',
            'usuario_registro_id' => 'required|exists:usuarios,id',
        ];             
    }


    public function messages(): array
    {
        return [
            'matricula_id.required' => 'El ID de la matrícula es obligatorio.',
            'matricula_id.exists' => 'La matrícula proporcionada no existe.',
            'estudiante_id.required' => 'El ID del estudiante es obligatorio.',
            'ciclo_id.required' => 'El ID del ciclo es obligatorio.',
            'sede_id.required' => 'El ID de la sede es obligatorio.',
            'usuario_registro_id.required' => 'El ID del usuario de registro es obligatorio.',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422)
        );
    }

}
