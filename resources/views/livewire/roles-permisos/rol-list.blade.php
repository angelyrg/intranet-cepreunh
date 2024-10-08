<div>
    {{-- Breadcrumb|start  --}}
    <x-breadcrumb 
        title="Lista de roles" 
        parent-url="#"
        parent-label="Configuración del Sistema"
        current-label="Roles"
        button-label="AGREGAR ROL"
        action="showForm"
    />
    {{-- Breadcrumb|end  --}}

    {{-- Content|start --}}
    <div class="card w-100 position-relative overflow-hidden">
        <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">Lista de estudiantes</h4>
        </div>
        <div class="card-body p-4">
        <div class="table-responsive table-xs mb-4 border rounded-1">
            <table class="table text-nowrap table-borderless table-bordered table-hover table-striped mb-0 align-middle" id="tblEstudiante">
                <thead class="text-dark fs-4">
                    <tr>
                        <th><h6 class="fs-4 fw-semibold mb-0">ACCIONES</h6></th>
                        <th><h6 class="fs-4 fw-semibold mb-0">ESTADO</h6></th>
                        <th><h6 class="fs-4 fw-semibold mb-0">ROLES</h6></th>
                        <th><h6 class="fs-4 fw-semibold mb-0">APLICACIÓN</h6></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>
                                <a wire:click="showForm({{ $role->id }})" class="btn badge fw-semibold py-1 bg-primary-subtle text-primary" role="button" title="Editar">
                                    <i class="ti ti-edit"></i>                                        
                                </a>
                                <a wire:click="delete({{ $role->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="btn badge fw-semibold py-1 bg-danger-subtle text-danger" role="button" title="Eliminar">
                                    <i class="ti ti-trash"></i>                                        
                                </a>
                            </td>
                            <td>
                                <a class="badge fw-semibold py-1 bg-primary-subtle text-primary" role="button"><small>{{ __('ACTIVO') }}</small></a>
                                {{-- @if($role->estado == 1)
                                <a class="badge fw-semibold py-1 bg-primary-subtle text-primary" role="button"><small>{{ __('ACTIVO') }}</small></a>
                                @elseif($role->estado == 0)
                                <a class="badge fw-semibold py-1 bg-primary-subtle text-primary" role="button"><small>{{ __('SUSPENDIDO') }}</small></a>
                                @endif --}}
                            </td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->guard_name }}</td>                          
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
    {{-- Content|end --}}

    {{ $roles->links() }}

    {{-- Modal|docentes|atart --}}
    @if($showModal)
        <livewire:roles-permisos.rol-form :role-id="$id" wire:key="{{ $id ?? 'create' }}" />
    @endif
    {{-- Modal|docentes|end --}}
    
</div>