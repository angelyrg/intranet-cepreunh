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
    public $showModalAsignarRolUsuario = false;
    
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';

    #[On('empleado-saved')]
    public function updatingSearch(){
        $this->resetPage();
    }

    #[On('empleado-saved')]
    public function refreshList(){
        $this->resetPage();
    }

    public function render()
    {

        // order by empleaos.id desc
        $empleados = Empleado::with(['departamento', 'sede'])->where("nombres", "LIKE", "%{$this->search}%")->orderBy('id', 'desc')->paginate(10);

        return view('livewire.empleado.empleado-list', compact('empleados'));
    }

    public function delete($empleadoId){
        $empleados = Empleado::find($empleadoId);
        if($empleados){
            $empleados->delete(); // Soft delete
            $this->dispatch('show-alert', 'Empleado eliminado con éxito');
        }
    }

    public function showForm($empleadoId = null){
        $this->id = $empleadoId;
        $this->showModal = true;
    }

    #[On('empleados-modal-closed')]
    public function hideModal(){
        $this->showModal = false;
    }

    public function copyCorreo($correo)
    {
        // Asegúrate de que $correo tiene un valor antes de despachar el evento
        logger('Correo a copiar: ' . $correo);
        $this->dispatch('copyToClipboard', ['texto' => $correo]);
    }

    // jneskenz => app|asignar-rol-usuario|start

    #[On('modal-closed-asignar-rol-usuario')]
    public function hideModalAsignarRolUsuario(){
        $this->showModalAsignarRolUsuario = false;
    }

    public function assignRoleUsuario($empleadoId = null){

        $this->id = $empleadoId;
        $this->showModalAsignarRolUsuario = true;
    }


    // jneskenz => app|asignar-rol-usuario|end

}
