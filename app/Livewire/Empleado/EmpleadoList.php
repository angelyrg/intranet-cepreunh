<?php

namespace App\Livewire\Empleado;

use App\Models\Intranet\Empleado;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class EmpleadoList extends Component
{
    public $id;
    
    public $title = 'Empleados';
    public $showModal = false;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {

        $empleados = Empleado::where("nombres", "LIKE", "%{$this->search}%")->paginate(10);

        return view('livewire.empleado.empleado-list', compact('empleados'));
    }

    public function delete($empleadoId){
        $usuarios = Empleado::find($empleadoId);
        if($usuarios){
            $usuarios->delete();
            $this->dispatch('show-alert', 'Usuario eliminado con éxito');
        }
    }

    public function showForm($empleadoId = null){
        $this->id = $empleadoId;
        $this->showModal = true;
    }

    #[On('modal-closed')]
    public function hideModal(){
        $this->showModal = false;
    }



}
