<div>
    {{-- Breadcrumb|start  --}}
    <div class="row">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Lista de roles</h4>
                    <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="../main/index.html">Sistemas</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Roles</li>
                    </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center">
                        {{-- <button type="button" class="btn btn-primary btnAddEstudiante">
                            <i class="ti ti-books fs-4"></i> NUEVO REGISTRO
                        </button> --}}
                        <button wire:click="showForm" class="btn btn-primary"><i class="ti ti-books fs-4"></i> AGREGAR ROL</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
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