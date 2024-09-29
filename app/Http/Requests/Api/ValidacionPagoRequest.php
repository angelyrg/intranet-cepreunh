<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ValidacionPagoRequest extends FormRequest
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
            'dni' => 'required|string|regex:/^[0-9]{8}$/',
            'nTransaccion' => 'required|string|max:20',
            'ciclo' => 'required|integer|exists:ciclos,id',
        ];
    }

    public function messages(): array
    {
        return [
            'dni.required' => 'El DNI es requerido',
            'dni.regex' => 'El DNI debe tener 8 dígitos',
            'nTransaccion.required' => 'El número de transacción es requerido',
            'nTransaccion.max' => 'El número de transacción no puede exceder los 20 caracteres',
            'ciclo.required' => 'El ciclo es requerido',
            'ciclo.exists' => 'El ciclo seleccionado no está disponible.',
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
