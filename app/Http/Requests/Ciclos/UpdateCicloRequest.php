<?php

namespace App\Http\Requests\Ciclos;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateCicloRequest extends FormRequest
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
            'tipos_ciclos_id' => [
                'required',
                'integer',
                Rule::exists('tipos_ciclos', 'id')->where(function ($query) {
                    $query->where('estado', 1);
                }),
            ],
            'descripcion' => 'required|string|max:255|regex:/^[\w\s\-]+$/u',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'duracion' => 'required|integer|min:1',
            'dias_lectivos' => 'required|array|min:1',
            'dias_lectivos.*' => 'in:1,2,3,4,5,6,7',
            'estado' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'tipos_ciclos_id.required' => 'El campo área es obligatorio.',
            'tipos_ciclos_id.exists' => 'El área seleccionada no es válida.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.string' => 'La descripción debe ser un texto válido.',
            'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',
            'descripcion.regex' => 'La descripción solo puede contener letras, espacios y guiones.',

            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.required' => 'La fecha de fin es obligatoria.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.',

            'dias_lectivos.required' => 'Debe seleccionar al menos un día lectivo.',
            'dias_lectivos.array' => 'Los días lectivos deben ser un arreglo.',
            'dias_lectivos.min' => 'Debe seleccionar al menos un día lectivo.',
            'dias_lectivos.*.in' => 'Los valores de los días lectivos deben estar entre 1 y 7 (lunes a domingo).',

            'duracion.required' => 'La duración es obligatoria.',
            'duracion.integer' => 'La duración debe ser un número entero.',
            'duracion.min' => 'La duración debe ser al menos 1 semana.',

            'estado.boolean' => 'El estado debe ser verdadero o falso.',
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
