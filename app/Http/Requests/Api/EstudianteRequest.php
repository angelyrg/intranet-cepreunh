<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EstudianteRequest extends FormRequest
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
            'tipo_documento_id' => 'required|integer',
            'nro_documento' => 'required|string|regex:/^[0-9]+$/',
            'nombres' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date|before:today',
            'pais_nacimiento' => 'required|string',
            'nacionalidad' => 'required|string',
            'telefono_personal' => 'required|string|regex:/^[0-9]+$/|min:9|max:9',
            'whatsapp' => 'nullable|string|regex:/^[0-9]+$/|min:9|max:9',
            'correo_personal' => 'required|email',
            'correo_institucional' => 'nullable|email',
            'colegio_id' => 'required|integer',
            'year_culminacion' => 'nullable|integer|min:1900|max:' . date('Y'),
            'ubigeodepartamento_id' => 'required|string',
            'ubigeoprovincia_id' => 'required|string',
            'ubigeodistrito_id' => 'required|string',
            'direccion' => 'required|string',
            'apoderado_id' => 'nullable|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'tipo_documento_id.required' => 'El tipo de documento es requerido',
            'tipo_documento_id.integer' => 'El tipo de documento debe ser un número entero',
            'nro_documento.required' => 'El número de documento es requerido',
            'nro_documento.regex' => 'El número de documento debe ser solo números',
            'nombres.required' => 'El nombre es requerido',
            'nombres.max' => 'El nombre no puede exceder los 100 caracteres',
            'apellido_paterno.required' => 'El apellido paterno es requerido',
            'apellido_paterno.max' => 'El apellido paterno no puede exceder los 100 caracteres',
            'apellido_materno.required' => 'El apellido materno es requerido',
            'apellido_materno.max' => 'El apellido materno no puede exceder los 100 caracteres',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento no puede ser en el futuro.',
            'pais_nacimiento.required' => 'El país de nacimiento es requerido',
            'nacionalidad.required' => 'La nacionalidad es requerida',
            'telefono_personal.required' => 'El teléfono personal es requerido',
            'telefono_personal.regex' => 'El teléfono debe ser solo números',
            'telefono_personal.min' => 'El teléfono debe tener exactamente 9 dígitos',
            'telefono_personal.max' => 'El teléfono debe tener exactamente 9 dígitos',
            'whatsapp.regex' => 'El WhatsApp debe ser solo números',
            'whatsapp.min' => 'El WhatsApp debe tener exactamente 9 dígitos',
            'whatsapp.max' => 'El WhatsApp debe tener exactamente 9 dígitos',
            'correo_personal.required' => 'El correo personal es requerido',
            'correo_personal.email' => 'El correo personal debe ser un correo válido',
            'correo_institucional.email' => 'El correo institucional debe ser un correo válido',
            'colegio_id.required' => 'El colegio es requerido',
            'colegio_id.integer' => 'El colegio debe ser un número entero',
            'year_culminacion.min' => 'El año debe ser mayor a 1900',
            'year_culminacion.max' => 'El año no puede ser mayor a ' . date('Y'),
            'ubigeodepartamento_id.required' => 'El departamento es requerido',
            'ubigeoprovincia_id.required' => 'La provincia es requerida',
            'ubigeodistrito_id.required' => 'El distrito es requerido',
            'direccion.required' => 'La dirección es requerida',
            'apoderado_id.integer' => 'El apoderado debe ser un número entero',
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
