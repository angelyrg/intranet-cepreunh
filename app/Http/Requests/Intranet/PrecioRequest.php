<?php
namespace App\Http\Requests\Intranet;

use Illuminate\Foundation\Http\FormRequest;

class PrecioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'forma_de_pago_id' => 'required|exists:formas_de_pago,id',
            'ciclo_id' => 'required|exists:ciclos,id',
            'sede_id' => 'required|exists:sedes,id',
            'area_id' => 'required|exists:areas,id',
            'monto' => 'required|numeric|min:0',
            'fraccionado' => 'boolean',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['id'] = 'required|exists:precios,id';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'forma_de_pago_id.required' => 'El campo forma de pago es obligatorio.',
            'forma_de_pago_id.exists' => 'La forma de pago seleccionada no es válida.',
            'ciclo_id.required' => 'El campo ciclo es obligatorio.',
            'ciclo_id.exists' => 'El ciclo seleccionado no es válido.',
            'sede_id.required' => 'El campo sede es obligatorio.',
            'sede_id.exists' => 'La sede seleccionada no es válida.',
            'area_id.required' => 'El campo área es obligatorio.',
            'area_id.exists' => 'El área seleccionada no es válida.',
            'monto.required' => 'El campo monto es obligatorio.',
            'monto.numeric' => 'El monto debe ser un número.',
            'monto.min' => 'El monto debe ser mayor o igual a 0.',
            'fraccionado.boolean' => 'El campo fraccionado debe ser verdadero o falso.',
            'id.required' => 'El campo ID es obligatorio para la actualización.',
            'id.exists' => 'El precio seleccionado no es válido.',
        ];
    }
}
