<?php

namespace App\Livewire\Matricula;

use App\Models\Intranet\Pago;
use Livewire\Component;

class PagosLista extends Component
{
    public $matricula_id;
    public $pagos;

    protected $listeners = ['pagoMatriculaRegistrado' => 'obtenerPagos'];


    public function mount($matricula_id)
    {
        $this->matricula_id = $matricula_id;
        $this->obtenerPagos();
    }

    public function obtenerPagos()
    {
        $this->pagos = Pago::with('forma_de_pago', 'banco')->where('matricula_id', $this->matricula_id)->get();
    }

    public function render()
    {
        return view('livewire.matricula.pagos-lista');
    }
}
