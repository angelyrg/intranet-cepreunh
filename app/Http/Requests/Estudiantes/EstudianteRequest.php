<?php

namespace App\Http\Requests\Estudiantes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            /* INFORMACIÓN BÁSICA */
            'tipo_documento_id' => [
                'required',
                'integer',
                Rule::exists('tipos_documentos', 'id')->where(function ($query) {
                    $query->where('estado', 1);
                }),
            ],
            'nro_documento' => [
                'required',
                'string',
                'max:20',
                Rule::unique('estudiantes')->where(function ($query) {
                    $query->where('estado', 1);
                })->ignore($this->route('estudiante'))
            ],
            'nombres' => 'required|string|max:150',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'genero_id' => 'required|integer|exists:generos,id',
        
            /* INFORMACIÓN DE NACIMIENTO */
            'pais_nacimiento' => 'required|string|size:2',
            'nacionalidad' => 'required|string',
            'nacimiento_ubigeodistrito_id' => 'nullable|string|max:6',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'estado_civil_id' => 'required|integer|exists:estados_civiles,id',
            'identidad_etnica_id' => 'nullable|integer|exists:identidades_etnicas,id',
            
            /* INFORMACIÓN DE CONTACTO */
            'direccion_ubigeodistrito_id' => 'nullable|string|max:6',
            'direccion' => 'nullable|string|max:255',
            'telefono_personal' => [
                'nullable',
                'regex:/^9\d{8}$/',
                'string',
                Rule::unique('estudiantes')->where(function ($query) {
                    $query->where('estado', 1);
                })->ignore($this->route('estudiante'))
            ],
            'whatsapp' => ['nullable', 'regex:/^9\d{8}$/', 'string'],
            

            'correo_personal' => 'nullable|email|max:200',
            'correo_institucional' => 'nullable|email|max:200',
            'telefono_apoderado' => ['nullable', 'regex:/^9\d{8}$/', 'string'],
            'correo_apoderado' => 'nullable|email|max:100',
            'parentesco_id' => 'nullable|integer|exists:parentescos,id',
        
            /* INFORMACIÓN ADICIONAL */
            'colegio_ubigeodistrito_id' => 'nullable|string|max:6',
            'colegio_id' => 'nullable|exists:colegios,id',
            'year_culminacion' => ['nullable', 'regex:/^(19|20)\d{2}$/', 'string'],
        
            'tiene_discapacidad' => 'nullable|boolean',
            'discapacidades' => 'nullable|array',
            'discapacidades.*' => 'exists:discapacidades,id',
        ];               
    }


    public function messages(): array
    {
        return [
            'tipo_documento_id.required' => 'El tipo de documento es obligatorio.',
            'tipo_documento_id.exists' => 'El tipo de documento seleccionado no es válido.',
            'nro_documento.required' => 'El número de documento es obligatorio.',
            'nro_documento.max' => 'El número de documento no puede superar los 20 caracteres.',
            'nro_documento.unique' => 'El número de documento ya está registrado.',
            'nombres.required' => 'El nombre es obligatorio.',
            'nombres.string' => 'El nombre debe ser un texto válido.',
            'nombres.max' => 'El nombre no puede exceder los 150 caracteres.',
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'apellido_paterno.string' => 'El apellido paterno debe ser un texto válido.',
            'apellido_paterno.max' => 'El apellido paterno no puede exceder los 100 caracteres.',
            'apellido_materno.string' => 'El apellido materno debe ser un texto válido.',
            'apellido_materno.max' => 'El apellido materno no puede exceder los 100 caracteres.',
            'genero_id.required' => 'El género es obligatorio.',
            'genero_id.exists' => 'El género seleccionado no es válido.',
    
            // Información de nacimiento
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento no puede ser posterior a la fecha actual.',
            'pais_nacimiento.required' => 'El país de nacimiento es obligatorio.',
            'pais_nacimiento.size' => 'El código del país debe tener 2 caracteres.',
            'nacionalidad.required' => 'La nacionalidad es obligatoria.',
            'nacionalidad.size' => 'El código de nacionalidad debe tener 2 caracteres.',
            'identidad_etnica_id.exists' => 'La identidad étnica seleccionada no es válida.',
    
            // Información de contacto
            'telefono_personal.regex' => 'El teléfono personal debe comenzar con 9 y ser seguido de 8 dígitos.',
            'whatsapp.regex' => 'El número de WhatsApp debe comenzar con 9 y ser seguido de 8 dígitos.',
            'correo_personal.email' => 'El correo electrónico personal debe ser una dirección válida.',
            'correo_institucional.email' => 'El correo electrónico institucional debe ser una dirección válida.',
            'telefono_apoderado.regex' => 'El teléfono del apoderado debe comenzar con 9 y ser seguido de 8 dígitos.',
            'correo_apoderado.email' => 'El correo del apoderado debe ser una dirección válida.',
            'parentesco_id.exists' => 'El parentesco seleccionado no es válido.',
    
            // Información adicional
            'colegio_ubigeodistrito_id.string' => 'El código de distrito del colegio debe ser un texto válido.',
            'colegio_id.exists' => 'El colegio seleccionado no es válido.',
            'year_culminacion.regex' => 'El año de culminación debe ser un número entre 1900 y 2099.',
    
            // Discapacidad
            'tiene_discapacidad.boolean' => 'El valor de "¿Tiene discapacidad?" debe ser verdadero o falso.',
            'discapacidades.array' => 'Las discapacidades deben ser una lista.',
            'discapacidades.min' => 'Debe seleccionar al menos una discapacidad.',
            'discapacidades.*.exists' => 'Cada discapacidad seleccionada debe ser válida.',
        ];
    }
}
