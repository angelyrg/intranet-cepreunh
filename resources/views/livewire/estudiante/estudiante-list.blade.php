

<div>
    {{-- Breadcrumb|start  --}}
    <div class="row">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Lista de estudiantes</h4>
                    <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="#">Administración</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Estudiantes</li>
                    </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center">
                        @can('estudiante.crear')
                        <button wire:click="showForm" class="btn btn-primary"><i class="ti ti-books fs-4"></i> AGREGAR ESTUDIANTE</button>
                        @endcan
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
        {{-- <button wire:click="showForm">Agregar Estudiante</button> --}}
        </div>
        <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1">
            <table class="table text-nowrap mb-0 align-middle" id="tblEstudiante">
                <thead class="text-dark fs-4">
                    <tr>
                        <th><h6 class="fs-4 fw-semibold mb-0"></h6></th>
                        <th><h6 class="fs-4 fw-semibold mb-0">ESTADO</h6></th>
                        <th><h6 class="fs-4 fw-semibold mb-0">NOMBRES</h6></th>
                        <th><h6 class="fs-4 fw-semibold mb-0">AP. PATERNO</h6></th>
                        <th><h6 class="fs-4 fw-semibold mb-0">AP. MATERNO</h6></th>
                        <th><h6 class="fs-4 fw-semibold mb-0">N° DOC</h6></th>
                        <th><h6 class="fs-4 fw-semibold mb-0">CORREO INSTITUCIONAL</h6></th>
                        <th><h6 class="fs-4 fw-semibold mb-0">TELÉFONO</h6></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>
                                {{-- <a wire:click="showForm({{ $student->id }})" class="btn badge fw-semibold py-1 bg-primary-subtle text-primary" role="button" title="Editar">
                                    <i class="ti ti-edit"></i>                                        
                                </a> --}}
                                @can('estudiante.editar')
                                <a href="{{ route('estudiante.edit', $student->id) }}" class="btn badge fw-semibold py-1 bg-primary-subtle text-primary" title="Editar">
                                    <i class="ti ti-edit"></i>
                                </a>
                                @endcan
                                @can('estudiante.eliminar')
                                <a wire:click="delete({{ $student->id }})" onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()" class="btn badge fw-semibold py-1 bg-danger-subtle text-danger" role="button" title="Eliminar">
                                    <i class="ti ti-trash"></i>                                        
                                </a>
                                @endcan
                            </td>
                            <td>
                                @if($student->estado == 1)
                                <a class="badge fw-semibold py-1 bg-primary-subtle text-primary" role="button"><small>{{ __('ACTIVO') }}</small></a>
                                @elseif($student->estado == 0)
                                <a class="badge fw-semibold py-1 bg-primary-subtle text-primary" role="button"><small>{{ __('SUSPENDIDO') }}</small></a>
                                @endif
                            </td>
                            <td>{{ $student->nombres }}</td>
                            <td>{{ $student->apellido_paterno }}</td>
                            <td>{{ $student->apellido_materno }}</td>
                            <td>{{ $student->nro_documento }}</td>
                            <td>{{ $student->correo_institucional }}</td>
                            <td>{{ $student->telefono_personal }}</td>                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
    {{-- Content|end --}}

    {{ $students->links() }}

    {{-- Modal|docentes|atart --}}
    @if($showModal)
        <livewire:estudiante.estudiante-form :student-id="$id" wire:key="{{ $id ?? 'create' }}" />
    @endif
    {{-- Modal|docentes|end --}}
    
</div>