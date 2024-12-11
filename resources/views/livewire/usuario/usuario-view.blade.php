<div>
    {{-- Breadcrumb|start  --}}
    <x-breadcrumb 
        title="Lista de {{ $title }}" 
        parent-url="#"
        parent-label="Configuración del Sistema"
        current-label="Usuarios"
        button-label=""
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
            @if($usuarios->count())
                <div class="table-responsive table-xs mb-2 border rounded-1">
                    <table class="table text-nowrap table-sm fs-2 table-borderless table-bordered table-hover table-striped mb-0 align-middle" id="tblUsuarios">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th><h6 class="fs-2 fw-bold py-1 mb-0">ACCIONES</h6></th>
                                <th><h6 class="fs-2 fw-bold py-1 mb-0">ESTADO</h6></th>
                                <th><h6 class="fs-2 fw-bold py-1 mb-0">NOMBRES</h6></th>
                                <th><h6 class="fs-2 fw-bold py-1 mb-0">EMAIL</h6></th>
                                <th><h6 class="fs-2 fw-bold py-1 mb-0"></h6></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                                <tr>
                                    <td style="width: 10%">
                                        <button type="button" class="btn badge fw-semibold p-1 bg-primary-subtle text-primary"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Más acciones">
                                            <i class="ti ti-menu-4"></i>
                                        </button>
                                        <ul class="dropdown-menu">                                          
                                            <li>
                                                <a class="dropdown-item bg-danger-subtle text-danger py-2" wire:click="delete({{ $usuario->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()">
                                                    <i class="ti ti-trash"></i> Eliminar
                                                </a>
                                            </li>                                            
                                        </ul>                                        
                                        {{-- <a wire:click="showForm({{ $usuario->id }})" class="btn badge fw-semibold py-1 bg-primary-subtle text-primary" title="Editar Usuarios">
                                            <i class="ti ti-edit"></i>                                        
                                        </a> --}}
                                        {{-- <a wire:click="assignRole({{ $usuario->id }})" class="btn badge fw-semibold py-1 bg-primary-subtle text-primary" title="Asignar roles">
                                            <i class="ti ti-user-cog"></i>
                                        </a> --}}
                                    </td>
                                    <td style="width: 10%">
                                        @if($usuario->estado == 1)
                                        <a class="badge fw-semibold py-1 fs-1 bg-primary-subtle text-primary" role="button"><small>{{ __('ACTIVO') }}</small></a>
                                        @elseif($usuario->estado == 0)
                                        <a class="badge fw-semibold py-1 fs-1 bg-primary-subtle text-primary" role="button"><small>{{ __('SUSPENDIDO') }}</small></a>
                                        @endif
                                    </td>
                                    <td>{{ $usuario->name }}</td>
                                    <td>{{ $usuario->email }}</td>                          
                                    <td></td>                          
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $usuarios->links() }}
            @else
                {{ __('No se encontró registros') }}
            @endif
        </div>
    </div>
    {{-- Content|end --}}

    

    {{-- Modal|docentes|atart --}}
    @if($showModal)
        <livewire:usuario.usuario-form :usuario-id="$id" wire:key="{{ $id ?? 'create' }}" />
    @endif
    {{-- Modal|docentes|end --}}
    
</div>