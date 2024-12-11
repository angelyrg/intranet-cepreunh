<?php

namespace App\Livewire\RolesPermisos;

use App\Models\Intranet\Permission;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PermisoView extends Component
{

    use WithPagination;

    public $title = 'Permisos';
    public $showModal = false;
    public $id;

    #[On('permiso-seved')]
    public function refreshList(){

    }

    public function render(){
        return view('livewire.roles-permisos.permiso-view', [
            'permisos' => Permission::paginate(20)
        ]);
    }

    
    public function delete($permisoId){
        $usuarios = Permission::find($permisoId);
        if($usuarios){
            $usuarios->delete();
            $this->dispatch('show-alert', 'Permiso eliminado con éxito');
        }
    }

    public function showForm($permisoId = null){
        $this->id = $permisoId;
        $this->showModal = true;
    }

    #[On('modal-closed')]
    public function hideModal(){
        $this->showModal = false;
    }
    
}
