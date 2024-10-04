<div>
    {{-- Breadcrumb|start  --}}
    <x-breadcrumb 
        title="Lista de {{ $title }}" 
        parent-url="#"
        parent-label="Configuración del Sistema"
        current-label="Permisos"
        button-label="AGREGAR PERMISOS"
        action="showForm"
    />
    {{-- Breadcrumb|end  --}}

    {{-- Content|start --}}
    <div class="card w-100 position-relative overflow-hidden">
        <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">Lista de {{ $title }}</h4>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive table-xs mb-2 border rounded-1">
                <table class="table text-nowrap table-borderless table-bordered table-hover table-striped mb-0 align-middle" id="tblUsuarios">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th><h6 class="fs-4 fw-semibold mb-0">ACCIONES</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">ESTADO</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">ROLES</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">APLICACIÓN</h6></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permisos as $permiso)
                            <tr>
                                <td>
                                    <a wire:click="showForm({{ $permiso->id }})" class="btn badge fw-semibold py-1 bg-primary-subtle text-primary" role="button" title="Editar Usuarios">
                                        <i class="ti ti-edit"></i>                                        
                                    </a>
                                    <a wire:click="delete({{ $permiso->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="btn badge fw-semibold py-1 bg-danger-subtle text-danger" role="button" title="Eliminar Usuarios">
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
                                <td>{{ $permiso->name }}</td>
                                <td>{{ $permiso->guard_name }}</td>                           
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $permisos->links() }}
        </div>
    </div>
    {{-- Content|end --}}

    

    {{-- Modal|docentes|atart --}}
    @if($showModal)
        <livewire:roles-permisos.permiso-form :permiso-id="$id" wire:key="{{ $id ?? 'create' }}" />
    @endif
    {{-- Modal|docentes|end --}}
    
</div>