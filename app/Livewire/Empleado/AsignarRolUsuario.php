<?php

namespace App\Livewire\Empleado;

use App\Models\Intranet\Empleado;
use Livewire\Attributes\On;
use Livewire\Component;

class AsignarRolUsuario extends Component
{
    public $id;


    public function mount($empleadoId){
        if($empleadoId){
            $empleado = Empleado::find($empleadoId);
            $this->id = $empleado->id;
        }
    }


    public function save(){
        dd($this->empleadoId);
    }

    public function closeModalAsignarRolUsuario()
    {
        $this->dispatch('modal-closed-asignar-rol-usuario');
    }


    public function render()
    {
        $empleado = Empleado::find($this->id);
        $nombre_completo = $empleado->nombres . ' ' . $empleado->apellido_paterno . ' ' . $empleado->apellido_materno;

        return view('livewire.empleado.asignar-rol-usuario', compact('empleado', 'nombre_completo'));
    }
}
