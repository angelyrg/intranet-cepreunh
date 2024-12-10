<?php

namespace App\Livewire\RolesPermisos;

use App\Models\Intranet\Permission;
use App\Models\Intranet\Role;
use Livewire\Component;
use Livewire\WithPagination;

class AsignarPermisoRol extends Component
{

    public $roleId;

    public $permisosDisponibles = [];

    public $permisosAsignados = [];

    // tabala 1 permisos disponibles
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';

    public function updatingSearch(){
        $this->resetPage();
    }

    public function mount($roleId = null)
    {

        // roles disponibles
        if ($roleId) {
            $rules = Role::find($roleId);

            if($rules){
                $this->roleId = $rules->id;
                // $this->permisosAsignados = $rules->permissions()->pluck('id')->toArray();
            }
        }
        // roles asignados

    }

    public function save(){


        dd('permiso');

        
    }

    public function savePermisosAsignados($permisos){

        dd($permisos);

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

        // $this->permisosDisponibles = $permisos;
        // $this->permisosAsignados = $permisos;

        $data = [
            'permisosDisponibles' => $permisos,
        ];

        return view('livewire.roles-permisos.asignar-permiso-rol', $data);
    }
}
