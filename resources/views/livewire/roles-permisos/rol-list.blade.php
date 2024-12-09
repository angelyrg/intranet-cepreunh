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
        {{-- <div class="px-4 py-3 border-bottom">
            <h4 class="card-title mb-0">Lista de estudiantes</h4>
        </div> --}}
        <div class="card-body p-4">
            <div class="table-responsive table-xs mb-4 border rounded-1">
                <table class="table text-nowrap table-borderless table-sm table-th-center table-bordered table-hover table-striped mb-0 align-middle" id="tblEstudiante">
                    <thead class="text-muted text-center">
                        <tr>
                            <th width="10%"><h6 class="fs-2 fw-bold py-1 mb-0">ACCIONES</h6></th>
                            <th width="10%"><h6 class="fs-2 fw-bold py-1 mb-0">ESTADO</h6></th>
                            <th><h6 class="fs-2 fw-bold py-1 mb-0">ROLES</h6></th>
                            <th><h6 class="fs-2 fw-bold py-1 mb-0">APLICACIÓN</h6></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td class="text-center">
                                    <span class="" title="Más acciones">
                                        <button class="btn badge bg-danger-subtle text-danger" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-menu-4"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                                        <li>
                                            <a class="dropdown-item bg-danger-subtle text-danger py-2" role="button" wire:click="delete({{ $role->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()">
                                                <i class="ti ti-trash"></i> Eliminar
                                            </a>
                                        </li>
                                        </ul>
                                    </span>  
                                    <a wire:click="showForm({{ $role->id }})" class="btn badge fw-semibold py-1 bg-primary-subtle text-primary" role="button" title="Editar">
                                        <i class="ti ti-edit"></i>                                        
                                    </a>
                                    <a wire:click="showFormPermisos({{ $role->id }})" class="btn badge fw-semibold py-1 bg-primary-subtle text-primary" role="button" title="Permisos">
                                        <i class="ti ti-clipboard-check"></i>
                                    </a>
                                    
                                </td>
                                <td class="text-center">
                                    <a class="badge fw-semibold py-1 bg-primary-subtle text-primary fs-1 " role="button">
                                        <small>{{ __('ACTIVO') }}</small>
                                    </a>
                                </td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->guard_name }}</td>                          
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-body">
            <div class="py-2">
                <div class="col-md-4 col-12">
                    <h4 class="card-title">Collapsed</h4>
                    <div class="containertreewview"></div>
                </div>
            </div>
        </div>
    </div>
    {{-- Content|end --}}

    {{ $roles->links() }}

    {{-- Modal|roles|atart --}}
    @if($showModal)
        <livewire:roles-permisos.rol-form :role-id="$id" wire:key="{{ $id ?? 'create' }}" />
    @endif
    {{-- Modal|roles|end --}}
    {{-- Modal|permisos|atart --}}
    @if($showModalAsignarPermiso)
        <livewire:roles-permisos.asignar-permiso-rol :role-id="$id" wire:key="{{ $id ?? 'create' }}" />
    @endif
    {{-- Modal|permisos|end --}}
    
</div>