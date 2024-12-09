<?php

namespace App\Livewire\RolesPermisos;

use App\Models\Intranet\Permission;
use App\Models\Intranet\Role;
use Livewire\Component;
use Livewire\WithPagination;

class AsignarPermisoRol extends Component
{
    use WithPagination;

    public $roleId;
    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($roleId = null)
    {
        if ($roleId) {
            $role = Role::findOrFail($roleId);
            $this->roleId = $role->id;
            
            // Fetch assigned permissions
            $this->permisosAsignados = $role->permissions()->pluck('id')->toArray();
        }
    }

    public function assignPermission($permissionId)
    {
        if (!$this->roleId) {
            $this->dispatch('error', message: 'Debe seleccionar un rol primero');
            return;
        }

        $role = Role::findOrFail($this->roleId);
        $permission = Permission::findOrFail($permissionId);

        // Check if permission is not already assigned
        if (!$role->permissions->contains($permission->id)) {
            $role->permissions()->attach($permission->id);
            
            // Refresh assigned permissions
            $this->permisosAsignados = $role->permissions()->pluck('id')->toArray();
            
            $this->dispatch('success', message: 'Permiso asignado correctamente');
        }
    }

    public function removePermission($permissionId)
    {
        if (!$this->roleId) {
            $this->dispatch('error', message: 'Debe seleccionar un rol primero');
            return;
        }

        $role = Role::findOrFail($this->roleId);
        $permission = Permission::findOrFail($permissionId);

        $role->permissions()->detach($permission->id);
        
        // Refresh assigned permissions
        $this->permisosAsignados = $role->permissions()->pluck('id')->toArray();
        
        $this->dispatch('success', message: 'Permiso removido correctamente');
    }

    public function render()
    {
        // Fetch available permissions (not yet assigned to the role)
        $query = Permission::query();
        
        if ($this->search) {
            $query->where("name", "LIKE", "%{$this->search}%");
        }

        // If a role is selected, exclude already assigned permissions
        if ($this->roleId) {
            $assignedPermissionIds = Role::findOrFail($this->roleId)->permissions()->pluck('id');
            $query->whereNotIn('id', $assignedPermissionIds);
        }

        $permisosDisponibles = $query->paginate(20);

        // Fetch assigned permissions
        $permisosAsignados = $this->roleId ? Role::findOrFail($this->roleId)->permissions()->get() : collect();

        return view('livewire.roles-permisos.asignar-permiso-rol', [
            'permisosDisponibles' => $permisosDisponibles,
            'permisosAsignados' => $permisosAsignados,
        ]);
    }

    public function closeModal()
    {
        $this->dispatch('modal-closed-asignar-permiso');
    }
}