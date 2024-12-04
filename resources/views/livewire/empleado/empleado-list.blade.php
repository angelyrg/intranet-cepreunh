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
            <h4 class="card-title mb-0">Lista de {{ $title }}</h4>
        </div>
        <div class="card-header">
            <input wire:model.lazy="search" class="form-control" placeholder="Buscar registros">
        </div>
        <div class="card-body">
            @if($empleados->count())
                <div class="table-responsive table-xs mb-2 border rounded-1">
                    <table class="table text-nowrap table-borderless table-bordered table-hover table-striped mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th><h6 class="fs-4 fw-semibold mb-0">ACCIONES</h6></th>
                                <th><h6 class="fs-4 fw-semibold mb-0">ESTADO</h6></th>
                                <th><h6 class="fs-4 fw-semibold mb-0">NOMBRES</h6></th>
                                <th><h6 class="fs-4 fw-semibold mb-0">APELLIDOS</h6></th>
                                <th><h6 class="fs-4 fw-semibold mb-0">TELÉFONO | WHATSAPP</h6></th>
                                <th><h6 class="fs-4 fw-semibold mb-0">SEDE</h6></th>
                                <th><h6 class="fs-4 fw-semibold mb-0">CORREO</h6></th>
                                <th><h6 class="fs-4 fw-semibold mb-0">CORREO INSTITUCIONAL</h6></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($empleados as $empleado)
                                <tr>
                                    <td>
                                        <button type="button" class="btn badge fw-semibold p-1 bg-primary-subtle text-primary"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Más acciones">
                                            <i class="ti ti-menu-4"></i>
                                        </button>
                                        <ul class="dropdown-menu">                                          
                                            <li>
                                                <a class="dropdown-item bg-danger-subtle text-danger py-2" wire:click="delete({{ $empleado->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()">
                                                    <i class="ti ti-trash"></i> Eliminar
                                                </a>
                                            </li>                                            
                                        </ul>                                        
                                        <a wire:click="showForm({{ $empleado->id }})" class="btn badge fw-semibold py-1 bg-primary-subtle text-primary" title="Editar Usuarios">
                                            <i class="ti ti-edit"></i>                                        
                                        </a>
                                        <a wire:click="assignRole({{ $empleado->id }})" class="btn badge fw-semibold py-1 bg-primary-subtle text-primary" title="Asignar roles">
                                            <i class="ti ti-user-cog"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @if($empleado->estado == 1)
                                        <a class="badge fw-semibold py-1 bg-primary-subtle text-primary" role="button"><small>{{ __('ACTIVO') }}</small></a>
                                        @elseif($empleado->estado == 0)
                                        <a class="badge fw-semibold py-1 bg-primary-subtle text-primary" role="button"><small>{{ __('SUSPENDIDO') }}</small></a>
                                        @endif
                                    </td>
                                    <td>{{ $empleado->nombres }}</td>
                                    <td>{{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}</td>                          
                                    <td>{{ $empleado->telefono_personal }} | {{ $empleado->whatsapp }}</td>
                                    <td>
                                        @if($empleado->sede)
                                            {{ $empleado->sede->descripcion }}
                                        @else
                                            <small class="fst-italic">Sin sede</small>
                                        @endif
                                    </td>
                                    
                                    <td>{{ $empleado->correo_personal }}</td>                          
                                    <td>{{ $empleado->correo_institucional }}</td>                    
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
    {{-- Modal|empleados|end --}}
    
</div>