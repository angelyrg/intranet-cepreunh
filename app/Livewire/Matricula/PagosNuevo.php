<?php

namespace App\Livewire\Matricula;

use App\Models\Intranet\Banco;
use App\Models\Intranet\FormaDePago;
use App\Models\Intranet\Pago;
use Carbon\Carbon;
use Livewire\Component;

class PagosNuevo extends Component
{
    public $matricula_id, $forma_de_pago_id, $banco_id, $fecha_pago, $cod_operacion, $descripcion_pago,
        $n_transaccion, $monto, $comision, $monto_neto, $condicion_pago= 'Cancelado';

    public $formasDePago, $bancos;

    public function mount($matricula_id)
    {
        $this->matricula_id = $matricula_id;
        $this->formasDePago = FormaDePago::all();
        $this->bancos = Banco::all();
        $this->fecha_pago = Carbon::now()->format('Y-m-d\TH:i');
    }

    protected $rules = [
        'forma_de_pago_id' => 'required|exists:formas_de_pago,id',
        'banco_id' => 'required|exists:bancos,id',
        'fecha_pago' => 'required|date',
        'cod_operacion' => 'nullable|string|max:255',
        'descripcion_pago' => 'required|string|max:255',
        'n_transaccion' => 'required|string|max:255',
        'monto' => 'required|numeric|min:0',
        'comision' => 'required|numeric|min:0',
        'monto_neto' => 'required|numeric|min:0',
        'condicion_pago' => 'required|in:Cancelado,Parcial',
    ];

    public function submit()
    {
        $this->validate();
        
        // Crea el nuevo pago
        Pago::create([
            'matricula_id' => $this->matricula_id,
            'forma_de_pago_id' => $this->forma_de_pago_id,
            'banco_id' => $this->banco_id,
            'fecha_pago' => $this->fecha_pago,
            'cod_operacion' => $this->cod_operacion,
            'descripcion_pago' => $this->descripcion_pago,
            'n_transaccion' => $this->n_transaccion,
            'monto' => $this->monto,
            'comision' => $this->comision,
            'monto_neto' => $this->monto_neto,
            'condicion_pago' => $this->condicion_pago,
        ]);

        // Reset the form fields
        $this->forma_de_pago_id = '';
        $this->banco_id = '';
        $this->fecha_pago = '';
        $this->cod_operacion = '';
        $this->descripcion_pago = '';
        $this->n_transaccion = '';
        $this->monto = '';
        $this->comision = '';
        $this->monto_neto = '';
        $this->condicion_pago = '';

        $this->dispatch('pagoMatriculaRegistrado');
        session()->flash('message', 'Pago registrado correctamente.');
    }

    public function render()
    {
        return view('livewire.matricula.pagos-nuevo');
    }
}
