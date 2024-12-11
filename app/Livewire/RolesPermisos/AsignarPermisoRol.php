<?php

namespace App\Livewire\RolesPermisos;

use App\Models\Intranet\Permission;
use App\Models\Intranet\Role;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class AsignarPermisoRol extends Component
{
    use WithPagination;

    public $roleId;

    // public $permisosDisponibles = [];

    public $permisosAsignados = [];

    public $permisosDisponiblesSelect = [];

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

            $this->permisosAsignados = $role->permissions()->pluck('id')->toArray();
        }
    }

    public function updatedPermisosDisponiblesSelect($value)
    {

        Log::info("Permisos seleccionados: {$value}", $this->permisosDisponiblesSelect );
    }

    public function assignPermission()
    {
        // Validar que se haya seleccionado un rol
        if (!$this->roleId) {
            $this->dispatch('error', 'Debe seleccionar un rol primero');
            return;
        }

        // Obtener el rol
        $role = Role::findOrFail($this->roleId);

        // Sincronizar permisos
        // $role->syncPermissions($this->permisosDisponiblesSelect);
        $role->givePermissionTo($this->permisosDisponiblesSelect);


        // Mensaje de éxito
        $this->dispatch('success', 'Permisos actualizados correctamente');

        // Opcional: limpiar selección
        $this->permisosDisponiblesSelect = [];
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


        $this->permisosAsignados = $role->permissions()->pluck('id')->toArray();

        $this->dispatch('success', message: 'Permiso removido correctamente');
    }

    public function render()
    {
        // Validar que se haya seleccionado un rol
        if (!$this->roleId) {
            return view('livewire.roles-permisos.asignar-permiso-rol', [
                'listPermisosAsignados' => collect(),
                'listPermisosAsignados' => collect(),
            ]);
        }

        // Buscar el rol actual
        $role = Role::findOrFail($this->roleId);

        // Obtener los permisos ya asignados al rol
        $assignedPermissionIds = $role->permissions()->pluck('id');

        // Consulta de permisos disponibles
        $listPermisosDisponibles = Permission::query()
            // Filtrar por búsqueda si existe
            ->when($this->search, function ($query) {
                return $query->where("name", "LIKE", "%{$this->search}%");
            })
            // Excluir permisos ya asignados
            ->whereNotIn('id', $assignedPermissionIds)
            // Paginar resultados
            ->get(); // Cambiado de paginate() a get()

        // Obtener permisos asignados al rol
        $listPermisosAsignados = $role->permissions;

        // Log para depuración (opcional)
        Log::info("Rol seleccionado: {$this->roleId}", [
            'Permisos disponibles' => $listPermisosDisponibles,
            'Permisos asignados' => $listPermisosAsignados->pluck('name'),
        ]);

        return view('livewire.roles-permisos.asignar-permiso-rol', [
            'listPermisosDisponibles' => $listPermisosDisponibles,
            'listPermisosAsignados' => $listPermisosAsignados,
        ]);
    }

    public function closeModal()
    {
        $this->dispatch('modal-closed-asignar-permiso');
    }
}
