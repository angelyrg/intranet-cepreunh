<?php

namespace App\Livewire\RolesPermisos;

use App\Models\Intranet\Role;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class RolList extends Component
{

    use WithPagination;

    public $id;
    public $title = 'Roles y permisos';

    public $showModal = false;
    public $showModalAsignarPermiso = false;

    #[On('role-saved')]
    public function refreshList()
    {
        // La lista se actualizará automáticamente
    }

    public function render()
    {
        return view('livewire.roles-permisos.rol-list', [
            'roles' => Role::paginate(10)
        ]);
    }

    public function delete($roleId)
    {
        $rules = Role::find($roleId);
        if ($rules) {
            $rules->delete();
            $this->dispatch('show-alert', message: 'Rol eliminado con éxito');
        }
    }

    public function showForm($roleId = null)
    {

        Log::error('data id ====> ', [$roleId]);
        $this->id = $roleId;
        $this->showModal = true;
        Log::error('data id 2 ====> ', [$this->id ]);

    }

    #[On('modal-closed')] 
    public function hideModal()
    {
        $this->showModal = false;
    }

    // jneskenz => permisos|start

    #[On('modal-closed-asignar-permiso')]
    public function hideModalAsignarPermiso()
    {
        $this->showModalAsignarPermiso = false;
    }

    public function showFormPermisos($roleId = null)
    {

        Log::error('data id ====> ', [$roleId]);
        $this->id = $roleId;
        $this->showModalAsignarPermiso = true;
        Log::error('data id 2 ====> ', [$this->id ]);

    }

    // jneskenz => permisos|end

}
