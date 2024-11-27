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
            'tipo_documento_id' => 'required|integer|exists:tipos_documentos,id',
            'nro_documento' => 'required|string|regex:/^[0-9]+$/',
            'nombres' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'required|string|max:100',
            'genero_id' => 'required|integer|exists:generos,id',
            'estado_civil_id' => 'required|integer|exists:estados_civiles,id',
            'fecha_nacimiento' => 'required|date|before:today',
            'pais_nacimiento' => 'required|string',
            'nacionalidad' => 'required|string',
            'telefono_personal' => 'nullable|string|regex:/^[0-9]+$/|min:9|max:9',
            'whatsapp' => 'nullable|string|regex:/^[0-9]+$/|min:9|max:9',
            'correo_personal' => 'required|email',
            'correo_institucional' => 'nullable|email',

            'discapacidad' => 'required|boolean',
            'discapacid_detalle' => 'nullable|string',
            'identidad_etnica_id' => 'required|integer|exists:identidades_etnicas,id',
            'nacimiento_ubigeodepartamento_id' => 'required|string|max:2',
            'nacimiento_ubigeoprovincia_id' => 'required|string|max:4',
            'nacimiento_ubigeodistrito_id' => 'required|string|max:6',

            'direccion_ubigeodepartamento_id' => 'required|string|max:2',
            'direccion_ubigeoprovincia_id' => 'required|string|max:4',
            'direccion_ubigeodistrito_id' => 'required|string|max:6',
            'direccion' => 'required|string|max:255',
            'colegio_id' => 'nullable|integer',
            'year_culminacion' => 'nullable|integer|min:1900|max:' . date('Y'),
            'apoderado_id' => 'nullable|integer|exists:apoderados,id',
        ];
    }

    public function messages()
    {
        return [
            'tipo_documento_id.required' => 'El tipo de documento es obligatorio.',
            'tipo_documento_id.integer' => 'El tipo de documento debe ser un número entero.',
            'tipo_documento_id.exists' => 'El tipo de documento seleccionado no es válido.',

            'nro_documento.required' => 'El número de documento es obligatorio.',
            'nro_documento.string' => 'El número de documento debe ser una cadena de texto.',
            'nro_documento.regex' => 'El número de documento solo puede contener números.',

            'nombres.required' => 'El nombre es obligatorio.',
            'nombres.string' => 'El nombre debe ser una cadena de texto.',
            'nombres.max' => 'El nombre no puede tener más de 100 caracteres.',

            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'apellido_paterno.string' => 'El apellido paterno debe ser una cadena de texto.',
            'apellido_paterno.max' => 'El apellido paterno no puede tener más de 100 caracteres.',

            'apellido_materno.required' => 'El apellido materno es obligatorio.',
            'apellido_materno.string' => 'El apellido materno debe ser una cadena de texto.',
            'apellido_materno.max' => 'El apellido materno no puede tener más de 100 caracteres.',

            'genero_id.required' => 'El género es obligatorio.',
            'genero_id.integer' => 'El género debe ser un número entero.',
            'genero_id.exists' => 'El género seleccionado no es válido.',

            'estado_civil_id.required' => 'El estado civil es obligatorio.',
            'estado_civil_id.integer' => 'El estado civil debe ser un número entero.',
            'estado_civil_id.exists' => 'El estado civil seleccionado no es válido.',

            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy.',

            'pais_nacimiento.required' => 'El país de nacimiento es obligatorio.',
            'pais_nacimiento.string' => 'El país de nacimiento debe ser una cadena de texto.',

            'nacionalidad.required' => 'La nacionalidad es obligatoria.',
            'nacionalidad.string' => 'La nacionalidad debe ser una cadena de texto.',

            'telefono_personal.regex' => 'El teléfono personal solo puede contener números.',
            'telefono_personal.min' => 'El teléfono personal debe tener exactamente 9 dígitos.',
            'telefono_personal.max' => 'El teléfono personal debe tener exactamente 9 dígitos.',

            'whatsapp.regex' => 'El WhatsApp solo puede contener números.',
            'whatsapp.min' => 'El WhatsApp debe tener exactamente 9 dígitos.',
            'whatsapp.max' => 'El WhatsApp debe tener exactamente 9 dígitos.',

            'correo_personal.required' => 'El correo personal es obligatorio.',
            'correo_personal.email' => 'El correo personal debe ser una dirección de correo electrónico válida.',

            'correo_institucional.email' => 'El correo institucional debe ser una dirección de correo electrónico válida.',

            'discapacidad.required' => 'El estado de discapacidad es obligatorio.',
            'discapacidad.boolean' => 'El estado de discapacidad debe ser verdadero o falso.',

            'discapacid_detalle.string' => 'El detalle de discapacidad debe ser una cadena de texto.',

            'identidad_etnica_id.required' => 'La identidad étnica es obligatoria.',
            'identidad_etnica_id.integer' => 'La identidad étnica debe ser un número entero.',
            'identidad_etnica_id.exists' => 'La identidad étnica seleccionada no es válida.',

            'nacimiento_ubigeodepartamento_id.required' => 'El departamento de nacimiento es obligatorio.',
            'nacimiento_ubigeodepartamento_id.string' => 'El departamento de nacimiento debe ser una cadena de texto.',
            'nacimiento_ubigeodepartamento_id.max' => 'El departamento de nacimiento no puede tener más de 2 caracteres.',

            'nacimiento_ubigeoprovincia_id.required' => 'La provincia de nacimiento es obligatoria.',
            'nacimiento_ubigeoprovincia_id.string' => 'La provincia de nacimiento debe ser una cadena de texto.',
            'nacimiento_ubigeoprovincia_id.max' => 'La provincia de nacimiento no puede tener más de 4 caracteres.',

            'nacimiento_ubigeodistrito_id.required' => 'El distrito de nacimiento es obligatorio.',
            'nacimiento_ubigeodistrito_id.string' => 'El distrito de nacimiento debe ser una cadena de texto.',
            'nacimiento_ubigeodistrito_id.max' => 'El distrito de nacimiento no puede tener más de 6 caracteres.',

            'direccion_ubigeodepartamento_id.required' => 'El departamento de dirección es obligatorio.',
            'direccion_ubigeodepartamento_id.string' => 'El departamento de dirección debe ser una cadena de texto.',
            'direccion_ubigeodepartamento_id.max' => 'El departamento de dirección no puede tener más de 2 caracteres.',

            'direccion_ubigeoprovincia_id.required' => 'La provincia de dirección es obligatoria.',
            'direccion_ubigeoprovincia_id.string' => 'La provincia de dirección debe ser una cadena de texto.',
            'direccion_ubigeoprovincia_id.max' => 'La provincia de dirección no puede tener más de 4 caracteres.',

            'direccion_ubigeodistrito_id.required' => 'El distrito de dirección es obligatorio.',
            'direccion_ubigeodistrito_id.string' => 'El distrito de dirección debe ser una cadena de texto.',
            'direccion_ubigeodistrito_id.max' => 'El distrito de dirección no puede tener más de 6 caracteres.',

            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.string' => 'La dirección debe ser una cadena de texto.',
            'direccion.max' => 'La dirección no puede tener más de 255 caracteres.',

            'colegio_id.integer' => 'El colegio debe ser un número entero.',

            'year_culminacion.integer' => 'El año de culminación debe ser un número entero.',
            'year_culminacion.min' => 'El año de culminación debe ser al menos 1900.',
            'year_culminacion.max' => 'El año de culminación no puede ser mayor que el año actual.',

            'apoderado_id.integer' => 'El apoderado debe ser un número entero.',
            'apoderado_id.exists' => 'El apoderado seleccionado no es válido.',
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
