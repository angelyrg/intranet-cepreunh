<?php

namespace App\Http\Requests\Matricula;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MatriculaEstudianteRequest extends FormRequest
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
        $idEstudiante = $this->input('id');

        return [
            'ciclo_id' => 'required',

            // Tipo de documento
            'tipo_documento_id' => [
                'required',
                'integer',
                Rule::exists('tipos_documentos', 'id')->where(function ($query) {
                    $query->where('estado', 1); // Solo tipos de documentos activos
                }),
            ],
            'nro_documento' => [
                'required',
                'string',
                'max:20',
                Rule::unique('estudiantes', 'nro_documento')->ignore($idEstudiante),
            ],

            // Nombres
            'nombres' => 'required|string|max:150|regex:/^[\pL\s\-]+$/u',

            // Apellido paterno
            'apellido_paterno' => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',

            // Apellido materno
            'apellido_materno' => 'nullable|string|max:100|regex:/^[\pL\s\-]+$/u',

            // Género
            'genero_id' => 'required|integer|exists:generos,id',

            'telefono_personal' => 'nullable|string|max:15',
            'whatsapp' => 'nullable|string|max:15',
            'correo_personal' => 'nullable|email|max:200',
            'correo_institucional' => 'nullable|email|max:200',

            // Estado civil
            'estado_civil_id' => 'required|integer|exists:estados_civiles,id',

            // Fecha de nacimiento
            'fecha_nacimiento' => 'required|date|before:today',

            // País de nacimiento
            'pais_nacimiento' => 'required|string|size:2',

            // Nacionalidad
            'nacionalidad' => 'required|string',

            // Identidad étnica
            'identidad_etnica_id' => 'nullable|integer|exists:identidades_etnicas,id',

            // ¿Tiene discapacidad?
            'tiene_discapacidad' => 'nullable|boolean', // Se asegura que sea un valor booleano (true/false)

            // Discapacidades seleccionadas (solo si "tiene_discapacidad" es verdadero)
            'discapacidades' => 'nullable|array|min:1',
            'discapacidades.*' => 'integer|exists:discapacidades,id',

            'direccion' => 'nullable|string|max:255',
            // 'colegio_id' => 'nullable|exists:colegios,id',
            'year_culminacion' => 'nullable|integer|min:1900|max:2099',
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
            'nombres.regex' => 'El nombre solo puede contener letras, espacios y guiones.',

            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'apellido_paterno.string' => 'El apellido paterno debe ser un texto válido.',
            'apellido_paterno.max' => 'El apellido paterno no puede exceder los 100 caracteres.',
            'apellido_paterno.regex' => 'El apellido paterno solo puede contener letras, espacios y guiones.',

            'apellido_materno.string' => 'El apellido materno debe ser un texto válido.',
            'apellido_materno.max' => 'El apellido materno no puede exceder los 100 caracteres.',
            'apellido_materno.regex' => 'El apellido materno solo puede contener letras, espacios y guiones.',

            'genero_id.required' => 'El género es obligatorio.',
            'genero_id.exists' => 'El género seleccionado no es válido.',

            'estado_civil_id.required' => 'El estado civil es obligatorio.',
            'estado_civil_id.exists' => 'El estado civil seleccionado no es válido.',

            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento no puede ser posterior a la fecha actual.',

            'pais_nacimiento.required' => 'El país de nacimiento es obligatorio.',
            'pais_nacimiento.size' => 'El código del país debe tener 2 caracteres.',

            'nacionalidad.required' => 'La nacionalidad es obligatoria.',
            'nacionalidad.size' => 'El código de nacionalidad debe tener 2 caracteres.',

            'identidad_etnica_id.exists' => 'La identidad étnica seleccionada no es válida.',

            'tiene_discapacidad.boolean' => 'El valor de "¿Tiene discapacidad?" debe ser verdadero o falso.',

            'discapacidades.array' => 'Las discapacidades deben ser una lista.',
            'discapacidades.min' => 'Debe seleccionar al menos una discapacidad.',
            'discapacidades.*.exists' => 'Cada discapacidad seleccionada debe ser válida.',
        ];
    }
}
