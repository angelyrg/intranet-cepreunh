<?php

namespace App\Http\Requests\Matricula;

use App\Models\Intranet\Matricula;
use App\Models\Intranet\Pago;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MatriculaRequest extends FormRequest
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
        $rules = [
            'ciclo_id' => [
                'required',
                'integer',
                Rule::exists('ciclos', 'id')->where(function ($query) {
                    $query->where('estado', 1);
                }),
                Rule::unique('matriculas')->where(function ($query) {
                    return $query->where('estudiante_id', $this->estudiante_id);
                })->ignore($this->route('matricula')),
            ],
            'estudiante_id' => [
                'required',
                'integer',
                Rule::exists('estudiantes', 'id')->where(function ($query) {
                    $query->where('estado', 1);
                }),
            ],
            'area_id' => [
                'required',
                'integer',
                Rule::exists('areas', 'id')->where(function ($query) {
                    $query->where('estado', 1);
                }),
            ],
            'carrera_id' => [
                'required',
                'integer',
                Rule::exists('carreras', 'id')->where(function ($query) {
                    $query->where('estado', 1);
                }),
            ],
            'sede_id' => [
                'required',
                'integer',
                Rule::exists('sedes', 'id')->where(function ($query) {
                    $query->where('estado', 1);
                }),
            ],
            'modalidad_estudio' => [
                'required',
                'string',
                'max:15',
                Rule::in(Matricula::MODALIDADES_ESTUDIO),
            ],
            'condicion_academica' => [
                'required',
                'string',
                'max:15',
                Rule::in(Matricula::CONDICIONES_ACADEMICAS),
            ],
            'cantidad_matricula' => [
                'required',
                'integer'
            ],
            'aula_ciclo_id' => [
                'required',
                'integer',
                Rule::exists('aula_ciclo', 'id'),
            ],
            'forma_de_pago_id' => [
                'required',
                'integer',
                Rule::exists('formas_de_pago', 'id')->where(function ($query) {
                    $query->where('estado', 1);
                }),
            ],
            'banco_id' => [
                'required',
                'integer',
                Rule::exists('bancos', 'id'),
            ],
            'cod_operacion' => [
                'nullable',
                'string',
                'max:100',
            ],
            'descripcion_pago' => [
                'required',
                'string',
                'max:100',
            ],
            'n_transaccion' => [
                'nullable',
                'string',
                'max:100',
            ],
            'monto' => [
                'required',
                'numeric',
                'min:0',
            ],
            'comision' => [
                'required',
                'numeric',
                'min:0',
            ],
            'monto_neto' => [
                'required',
                'numeric',
                'min:0',
            ],
            'condicion_pago' => [
                'required',
                'string',
                'max:15',
                Rule::in(Pago::CONDICIONES_PAGO),
            ],
            'fecha_pago' => [
                'required',
                'date',
            ],
            'aula_ciclo_actual_id' => [
                'nullable',
                'integer',
                Rule::exists('aula_ciclo', 'id'),
            ],
        ];

        return $rules;
    }


    public function messages(): array
    {
        return [
            'ciclo_id.required' => 'El ciclo es obligatorio.',
            'ciclo_id.integer' => 'El ciclo debe ser un número entero.',
            'ciclo_id.exists' => 'El ciclo seleccionado no existe o está inactivo.',
            'ciclo_id.unique' => 'Este estudiante ya está matriculado en el ciclo seleccionado.',

            'estudiante_id.required' => 'El estudiante es obligatorio.',
            'estudiante_id.integer' => 'El ID del estudiante debe ser un número entero.',
            'estudiante_id.exists' => 'El estudiante seleccionado no existe o está inactivo.',

            'area_id.required' => 'El área es obligatoria.',
            'area_id.integer' => 'El área debe ser un número entero.',
            'area_id.exists' => 'El área seleccionada no existe o está inactiva.',

            'carrera_id.required' => 'La carrera es obligatoria.',
            'carrera_id.integer' => 'La carrera debe ser un número entero.',
            'carrera_id.exists' => 'La carrera seleccionada no existe o está inactiva.',

            'sede_id.required' => 'La sede es obligatoria.',
            'sede_id.integer' => 'La sede debe ser un número entero.',
            'sede_id.exists' => 'La sede seleccionada no existe o está inactiva.',

            'modalidad_matricula.required' => 'La modalidad de matrícula es obligatoria.',
            'modalidad_matricula.string' => 'La modalidad de matrícula debe ser una cadena de texto.',
            'modalidad_matricula.max' => 'La modalidad de matrícula no puede tener más de 15 caracteres.',
            'modalidad_matricula.in' => 'La modalidad de matrícula debe ser ' . implode(' o ', Matricula::MODALIDADES_ESTUDIO) . '.',

            'aula_ciclo_id.required' => 'El aula ciclo es obligatoria.',
            'aula_ciclo_id.integer' => 'El aula ciclo debe ser un número entero.',
            'aula_ciclo_id.exists' => 'El aula ciclo seleccionado no existe.',

            'forma_de_pago_id.required' => 'La modalidad de pago es obligatoria.',
            'forma_de_pago_id.integer' => 'La modalidad de pago debe ser un número entero.',
            'forma_de_pago_id.exists' => 'La modalidad de pago seleccionada no existe o está inactiva.',

            'banco_id.required' => 'El banco es obligatorio.',
            'banco_id.integer' => 'El banco debe ser un número entero.',
            'banco_id.exists' => 'El banco seleccionado no existe o está inactivo.',

            'cod_operacion.required' => 'El código de operación es obligatorio.',
            'cod_operacion.string' => 'El código de operación debe ser una cadena de texto.',
            'cod_operacion.max' => 'El código de operación no puede tener más de 100 caracteres.',

            'descripcion_pago.required' => 'La descripción del pago es obligatoria.',
            'descripcion_pago.string' => 'La descripción del pago debe ser una cadena de texto.',
            'descripcion_pago.max' => 'La descripción del pago no puede tener más de 100 caracteres.',

            'n_transaccion.required' => 'El número de transacción es obligatorio.',
            'n_transaccion.string' => 'El número de transacción debe ser una cadena de texto.',
            'n_transaccion.max' => 'El número de transacción no puede tener más de 100 caracteres.',

            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric' => 'El monto debe ser un número.',
            'monto.min' => 'El monto debe ser mayor o igual a 0.',

            'comision.required' => 'La comisión es obligatoria.',
            'comision.numeric' => 'La comisión debe ser un número.',
            'comision.min' => 'La comisión debe ser mayor o igual a 0.',

            'monto_neto.required' => 'El monto neto es obligatorio.',
            'monto_neto.numeric' => 'El monto neto debe ser un número.',
            'monto_neto.min' => 'El monto neto debe ser mayor o igual a 0.',

            'condicion_pago.required' => 'La condición de pago es obligatoria.',
            'condicion_pago.string' => 'La condición de pago debe ser una cadena de texto.',
            'condicion_pago.max' => 'La condición de pago no puede tener más de 15 caracteres.',
            'condicion_pago.in' => 'La condición de pago debe ser ' . implode(' o ', Pago::CONDICIONES_PAGO) . '.',

            'fecha_pago.required' => 'La fecha de pago es obligatoria.',
            'fecha_pago.date' => 'La fecha de pago debe ser una fecha válida.',

            'aula_ciclo_actual_id.integer' => 'El aula ciclo actual debe ser un número entero.',
            'aula_ciclo_actual_id.exists' => 'El aula ciclo actual seleccionado no existe.',
        ];
    }
}
