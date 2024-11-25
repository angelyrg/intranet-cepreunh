<?php

namespace App\Http\Requests\Intranet;

use Illuminate\Foundation\Http\FormRequest;

class GenerarCuentaEmpleadoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'username' => 'required|unique:users,username',
            'password' => 'required',
            // 'sede_id' => 'required',
            'correo_personal' => 'required|email|unique:users,email',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'username.required' => 'El campo usuario es requerido',
            'username.unique' => 'Ya existe un usuario con este nombre de usuario, intente con otro',
            'password.required' => 'El campo contraseña es requerido',
            // 'sede_id.required' => 'El campo sede es requerido',
            'correo_personal.required' => 'El campo correo es requerido',
            'correo_personal.email' => 'El campo correo debe ser un email válido',
            'correo_personal.unique' => 'Ya existe un usuario con este correo, intente con otro',
        ];
    }
}
