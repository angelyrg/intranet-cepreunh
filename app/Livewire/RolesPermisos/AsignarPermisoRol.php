<?php

namespace App\Livewire\RolesPermisos;

use App\Models\Intranet\Permission;
use App\Models\Intranet\Role;
use Livewire\Component;
use Livewire\WithPagination;

class AsignarPermisoRol extends Component
{

    public $id;

    public $permisosDisponibles = [];

    public $permisosAsignados = [];

    // tabala 1 permisos disponibles
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';

    public function updatingSearch(){
        $this->resetPage();
    }

    // tabla 2 permisos asignados


    public function mount($roleId = null)
    {

        // roles disponibles
        if ($roleId) {
            $rules = Role::find($roleId);

            $this->id = $rules->id;
        }
        // roles asignados

    }

    public function save(){


        dd('permiso');

        
    }

    public function savePermisosAsignados($permisos){
        // foreach ($permisos as $permiso) {
        //     if (($key = array_search($permiso, $this->permisosDisponibles)) !== false) {
        //         unset($this->permisosDisponibles[$key]);
        //         $this->permisosAsignados[] = $permiso;
        //     }
        // }
        //TODO: MEJORAR ESTO
    }

    public function removePermisosAsignados(){

    }

    public function back(){
        dd('back');
    }

    public function closeModal()
    {
        $this->dispatch('modal-closed-asignar-permiso');
    }
    
    public function render()
    {
        $permisos = Permission::where("name", "LIKE", "%{$this->search}%")->paginate(20);

        // $permisosAsignados = Permission::where('role_id', $this->id)->get();

        $this->permisosDisponibles = $permisos;
        // $this->permisosAsignados = $permisos; //TODO:

        return view('livewire.roles-permisos.asignar-permiso-rol');
    }
}
