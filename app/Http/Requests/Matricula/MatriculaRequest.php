<?php

namespace App\Http\Requests\Matricula;

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
        return [
            'ciclo_id' => [
                'required',
                'integer',
                Rule::exists('ciclos', 'id')->where(function ($query) {
                    $query->where('estado', 1);
                }),
                Rule::exists('ciclos', 'id')->where(function ($query) {
                    $query->where('estado', 1);
                }),
                Rule::unique('matriculas')->where(function ($query) {
                    return $query->where('estudiante_id', $this->estudiante_id);
                })
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
        ];
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
        ];
    }
}
