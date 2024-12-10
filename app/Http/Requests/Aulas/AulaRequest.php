<?php

namespace App\Http\Requests\Aulas;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AulaRequest extends FormRequest
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
            'descripcion' => 'required|string|max:20',
            'piso' => 'required|integer|min:1',
            'aforo' => 'required|integer|min:1',
            'sede_id' => 'required|integer|exists:sedes,id',
        ];
    }

    public function messages(): array
    {
        return [
            'descripcion.required' => 'El campo descripción es obligatorio.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'descripcion.max' => 'La descripción no puede tener más de 20 caracteres.',

            'piso.required' => 'El campo piso es obligatorio.',
            'piso.integer' => 'El piso debe ser un número entero.',
            'piso.min' => 'El piso debe ser al menos 1.',

            'aforo.required' => 'El campo aforo es obligatorio.',
            'aforo.integer' => 'El aforo debe ser un número entero.',
            'aforo.min' => 'El aforo debe ser al menos 1.',

            'sede_id.required' => 'El campo sede es obligatorio.',
            'sede_id.integer' => 'El valor de sede debe ser un número entero.',
            'sede_id.exists' => 'La sede seleccionada no es válida. Por favor, elige una sede existente.',
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
