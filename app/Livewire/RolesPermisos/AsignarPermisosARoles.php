<?php

namespace App\Livewire\RolesPermisos;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AsignarPermisosARoles extends Component
{
    public $roleId;
    public $permisosDisponiblesSelect = [];
    public $role;
    public $permisos;
    public $roleName;

    public function mount($roleId)
    {
        $this->role = Role::findOrFail($roleId);
        $this->roleId = $this->role->id;
        $this->roleName = $this->role->name;

        $this->permisos = Permission::all();

        $this->permisosDisponiblesSelect = $this->role->permissions->pluck('name')->toArray();
    }

    public function assignPermissions()
    {
        $this->role = Role::findOrFail($this->roleId);

        // Validar si se seleccionaron permisos
        // if (empty($this->permisosDisponiblesSelect)) {
        //     session()->flash('error', 'Debe seleccionar al menos un permiso');
        //     return;
        // }

        try {
            $this->role->syncPermissions($this->permisosDisponiblesSelect);

            session()->flash('success', 'Permisos actualizados correctamente');
        } catch (\Exception $e) {
            // En caso de error, mostrar el mensaje de error
            session()->flash('error', 'Hubo un error al asignar los permisos: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.roles-permisos.asignar-permisos-a-roles');
    }

    public function closeModal()
    {
        $this->dispatch('modal-closed-asignar-permiso');
    }
}
