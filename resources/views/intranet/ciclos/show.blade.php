@extends('intranet.layouts.app')

@section('content')

{{-- TODO: Estandarizar los breadcrumbs --}}
{{-- Breadcrumb|start --}}
<div class="row">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <h4 class="fw-semibold mb-8">Detalles del ciclo</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('ciclos.index') }}">Ciclos</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Detalles</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Breadcrumb|end --}}

{{-- content|start --}}

<div class="row">
    <div class="col-12 col-md-6 col-lg-8">
        <div class="card shadow rounded-3">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title fw-semibold">{{ $ciclo->descripcion }}</h5>
                        {{-- <p class="card-subtitle">Detalles del ciclo académico</p> --}}
                    </div>
                    <div>
                        @if($ciclo->estado == 1)
                        <span class="badge fw-semibold py-1 bg-success-subtle text-success"><small>{{ __('ACTIVO') }}</small></span>
                        @elseif($ciclo->estado == 0)
                        <span class="badge fw-semibold py-1 bg-danger-subtle text-danger"><small>{{ __('INACTIVO') }}</small></span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-6 col-lg-7">Tipo:</label>
                            <div class="col-6 col-lg-5">
                                <p class="form-control-static mb-0">{{ $ciclo->tipo_ciclo->descripcion }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <label class="control-label text-end col-6 col-lg-7">Duración:</label>
                            <div class="col-6 col-lg-5">
                                <p class="form-control-static mb-0">{{ $ciclo->duracion }} semanas</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-6 col-lg-7">Fecha de Inicio:</label>
                            <div class="col-6 col-lg-5">
                                <p class="form-control-static mb-0">{{ $ciclo->fecha_inicio }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <label class="control-label text-end col-6 col-lg-7">Fecha de Finalización:</label>
                            <div class="col-6 col-lg-5">
                                <p class="form-control-static mb-0">{{ $ciclo->fecha_fin }}</p>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="row mt-4">
                    <div class="col d-flex align-items-center">
                        <label class="control-label text-end me-3">Días lectivos: </label>
                        <div>
                            <div class="d-flex gap-3 flex-wrap">
                                @foreach ($ciclo->dias_lectivos_texto as $dia)
                                <div class="bg-primary-subtle rounded-2 py-2 px-3 d-flex align-items-center justify-content-center">
                                    <small>{{ $dia }}</small>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
        <div class="card shadow rounded-3">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title fw-semibold">Opciones</h5>
                    </div>
                </div>
            </div>
            <div class="card-body p-4 pt-0">
                <div class="d-flex flex-column gap-2">
                    <div>
                        <button type="button" class="btn btn-outline-primary w-100 d-flex justify-content-center align-items-center gap-1" data-bs-toggle="modal"
                            data-bs-target="#modalCarreras">
                            <i class="ti ti-network"></i>
                            <span>Carreras</span>
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-primary w-100 d-flex justify-content-center align-items-center gap-1" data-bs-toggle="modal"
                            data-bs-target="#modalAsignaturas">
                            <i class="ti ti-books"></i>
                            <span>Asignaturas</span>
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-primary w-100 d-flex justify-content-center align-items-center gap-1" data-bs-toggle="modal"
                            data-bs-target="#modalAulas">
                            <i class="ti ti-door"></i>
                            <span>Aulas</span>
                        </button>
                    </div>
                    <div>

                        <button class="btn btn-outline-primary w-100 d-flex justify-content-center align-items-center gap-1"
                            type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <i class="ti ti-clock-cog"></i>
                            <span>Horario para estudiantes</span>
                        </button>
                    </div>
                    {{-- <div>
                        <button type="button" class="btn btn-outline-primary w-100 d-flex justify-content-center align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalPrecios">
                            <i class="ti ti-coin"></i>
                            <span>Precios</span>
                        </button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Estudiantes matriculados en el ciclo</h5>
                    <div>
                        @if($ciclo->estado == 1)
                        @can('matricula.crear')
                        <a class="btn btn-primary d-block" href={{ route('ciclos.matricula', $ciclo->id) }}>
                            <span><i class="ti ti-user-plus"></i></span>
                            <span>Matricular estudiante</span>
                        </a>
                        @endcan
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                @can('matriculas.lista')
                <livewire:ciclo.matriculas-table cicloId="{{ $ciclo->id }}" sedeId="{{ $sedeId }}" />
                @endcan
            </div>
        </div>
    </div>
</div>


<!-- Modal Carreras -->
<div class="modal fade" id="modalCarreras" tabindex="-1" aria-labelledby="modalCarrerasLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalCarrerasLabel">Carreras del ciclo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @livewire('ciclo.asignar-carreras-a-ciclo', ['cicloId' => $ciclo->id])
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Asignaturas -->
<div class="modal fade" id="modalAsignaturas" tabindex="-1" aria-labelledby="modalAsignaturasLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalAsignaturasLabel">Asignaturas del ciclo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @livewire('ciclo.asignar-asignaturas-a-ciclo', ['cicloId' => $ciclo->id])
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Precios -->
<div class="modal fade" id="modalPrecios" tabindex="-1" aria-labelledby="modalPreciosLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalPreciosLabel">Precios del ciclo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-warning text-center">En mantenimiento</p>
                <h2 class="text-center">🧑‍💻</h2>
                {{-- @livewire('ciclo.grupo-precio', ['cicloId' => $ciclo->id]) --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Aulas -->
<div class="modal fade" id="modalAulas" tabindex="-1" aria-labelledby="modalAulasLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalAulasLabel">Aulas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @livewire('ciclo.asignar-aulas-a-ciclo', ['cicloId' => $ciclo->id])
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

{{-- Offcanvas right --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Horario Estudiante</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <h6>Configuración para el registro de asistencia del estudiante</h6>

        @livewire('ciclo.configurar-horario-estudiante', ['cicloId' => $ciclo->id])
    </div>
</div>

{{-- content|end --}}

@endsection

@section('scripts')
<script src="{{ asset('assets/js/tools.js') }}"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        window.confirmDeletion = function(matriculaId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta matrícula y sus datos asociados serán eliminados. ¿Estás seguro de que deseas continuar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-outline-primary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('delete-matricula', {matriculaId: matriculaId});
                }
            });
        };
    });
</script>
@endsection