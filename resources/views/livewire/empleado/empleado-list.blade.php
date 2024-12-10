<div>
    {{-- Breadcrumb|start  --}}
    <x-breadcrumb 
        title="Lista de {{ $title }}" 
        parent-url="#"
        parent-label="Configuración del Sistema"
        current-label="{{ $title }}"
        button-label="AGREGAR EMPLEADO"
        action="showForm"
    />
    {{-- Breadcrumb|end  --}}

    {{-- Content|start --}}
    <div class="card w-100 position-relative overflow-hidden">
        <div class="px-4 py-3 border-bottom">
            @if(auth()->user()->can('empleados.index'))
            <h4 class="card-title mb-0">Lista de {{ $title }}</h4>
            @endif
        </div>
        <div class="card-header">
            <input wire:model.lazy="search" class="form-control" placeholder="Buscar registros">
        </div>
        <div class="card-body">
            @if($empleados->count())
                <div class="table-responsive table-xs mb-2 border rounded-1">
                    <table class="table text-nowrap table-sm fs-2 table-borderless table-bordered table-hover table-striped mb-0 align-middle">
                        <thead class="text-muted text-center">
                            <tr>
                                <th><h6 class="fs-2 fw-bold py-1 mb-0">ACCIONES</h6></th>
                                <th><h6 class="fs-2 fw-bold py-1 mb-0">ESTADO</h6></th>
                                <th><h6 class="fs-2 fw-bold py-1 mb-0">DEPARTAMENTO</h6></th>
                                <th><h6 class="fs-2 fw-bold py-1 mb-0">NOMBRES</h6></th>
                                <th><h6 class="fs-2 fw-bold py-1 mb-0">APELLIDOS</h6></th>
                                <th><h6 class="fs-2 fw-bold py-1 mb-0">TELÉFONO | WHATSAPP</h6></th>
                                <th><h6 class="fs-2 fw-bold py-1 mb-0">SEDE</h6></th>
                                <th><h6 class="fs-2 fw-bold py-1 mb-0">CORREO</h6></th>
                                <th><h6 class="fs-2 fw-bold py-1 mb-0">CORREO INSTITUCIONAL</h6></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($empleados as $empleado)
                                <tr>
                                    <td>
                                        <span class="" title="Más acciones">
                                            <button class="btn badge bg-danger-subtle text-danger" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-menu-4"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                                              <li>
                                                <a class="dropdown-item bg-danger-subtle text-danger py-2" role="button" wire:click="delete({{ $empleado->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()">
                                                    <i class="ti ti-trash"></i> Eliminar
                                                </a>
                                              </li>
                                            </ul>
                                        </span>                                     
                                        <a wire:click="showForm({{ $empleado->id }})" class="btn badge fw-semibold py-1 bg-primary-subtle text-primary" title="Editar Usuarios">
                                            <i class="ti ti-edit"></i>                                        
                                        </a>
                                        <a wire:click="assignRoleUsuario({{ $empleado->id }})" class="btn badge fw-semibold py-1 bg-primary-subtle text-primary" title="Asignación de usuario y roles">
                                            <i class="ti ti-user-cog"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @if($empleado->estado == 1)
                                        <a class="badge fw-semibold py-1 fs-1 bg-primary-subtle text-primary" role="button"><small>{{ __('ACTIVO') }}</small></a>
                                        @elseif($empleado->estado == 0)
                                        <a class="badge fw-semibold py-1 fs-1 bg-primary-subtle text-primary" role="button"><small>{{ __('SUSPENDIDO') }}</small></a>
                                        @endif
                                    </td>
                                    <td>{{ $empleado->departamento->descripcion }}</td>
                                    <td>{{ $empleado->nombres }}</td>
                                    <td>{{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}</td>                          
                                    <td>{{ $empleado->telefono_personal }} | {{ $empleado->whatsapp }}</td>
                                    <td>
                                        {{ $empleado->sede->descripcion }}
                                        {{-- @if($empleado->sede_id)
                                            {{ $empleado->sede->descripcion }}
                                        @else
                                            <small class="fst-italic">Sin sede</small>
                                        @endif --}}
                                    </td>                         
                                    <td>
                                        <a role="button" wire:click="copyCorreo('{{ $empleado->correo_personal }}')" title="{{ $empleado->correo_personal }}">
                                            {{Str::limit($empleado->correo_personal ?? '', 15) }}
                                        </a>
                                    </td>                          
                                    <td>
                                        <a role="button" wire:click="copyCorreo('{{ $empleado->correo_institucional }}')" title="{{ $empleado->correo_institucional }}">
                                            {{Str::limit($empleado->correo_institucional ?? '', 15) }}
                                        </a>
                                    </td>                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $empleados->links() }}
            @else
                {{ __('No se encontró registros') }}
            @endif
        </div>
    </div>
    {{-- Content|end --}}

    

    {{-- Modal|empleados|atart --}}
    @if($showModal)
        <livewire:empleado.empleado-form :empleado-id="$id" wire:key="{{ $id ?? 'create' }}" />
    @endif
    @if($showModalAsignarRolUsuario)
        <livewire:empleado.asignar-rol-usuario :empleado-id="$id" wire:key="{{ $id ?? 'create' }}" />
    @endif
    {{-- Modal|empleados|end --}}
    
</div>