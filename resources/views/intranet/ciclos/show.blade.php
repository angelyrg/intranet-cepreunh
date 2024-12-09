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
                        <p class="card-subtitle">Detalles del ciclo académico</p>
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
                    <div class="col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Tipo:</label>
                            <div class="col-md-5">
                                <p class="form-control-static mb-0">{{ $ciclo->tipo_ciclo->descripcion }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <label class="control-label text-end col-md-7">Duración:</label>
                            <div class="col-md-5">
                                <p class="form-control-static mb-0">{{ $ciclo->duracion }} semanas</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Fecha de Inicio:</label>
                            <div class="col-md-5">
                                <p class="form-control-static mb-0">{{ $ciclo->fecha_inicio }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <label class="control-label text-end col-md-7">Fecha de Finalización:</label>
                            <div class="col-md-5">
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
                        @if($ciclo->estado == 1)
                            <a class="btn btn-primary d-block" href={{ route('ciclos.matricula', $ciclo->id) }}>Matricular estudiante</a>
                        @endif
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-primary w-100 d-block" data-bs-toggle="modal"
                            data-bs-target="#modalCarreras">
                            <span>Carreras</span>
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-primary w-100 d-block" data-bs-toggle="modal"
                            data-bs-target="#modalAsignaturas">
                            <span>Asignaturas</span>
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-primary w-100 d-block" data-bs-toggle="modal" data-bs-target="#modalPrecios">
                            Precios
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Matrículas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap table-striped">
                        <thead class="header-item">
                            <tr>
                                <th>#</th>
                                <th>Nro Documento</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Género</th>
                                <th>Estado Civil</th>
                                <th>Area</th>
                                <th>Carrera</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($ciclo->matriculas->isNotEmpty())
                            @foreach ($ciclo->matriculas as $index => $matricula)
                            <tr class="search-items">
                                <td>
                                    {{ ($index+1) }}
                                </td>
                                <td>
                                    {{ $matricula->estudiante->nro_documento }}
                                </td>
                                <td>
                                    {{ $matricula->estudiante->nombres }}
                                </td>
                                <td>
                                    {{ $matricula->estudiante->apellido_paterno." ".$matricula->estudiante->apellido_materno }}
                                </td>
                                <td>
                                    {{ $matricula->estudiante->genero->descripcion }}
                                </td>
                                <td>
                                    {{ $matricula->estudiante->estado_civil->descripcion }}
                                </td>
                                <td>
                                    {{ $matricula->area->descripcion }}
                                </td>
                                <td>
                                    {{ $matricula->carrera->descripcion }}
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="8" class="text-center">No hay matrículas disponibles.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <hr>
                {{-- @livewire('ciclo.matriculas-table', ['cicloId' => $ciclo->id]) --}}
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
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

<!-- Modal -->
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

<!-- Modal -->
<div class="modal fade" id="modalPrecios" tabindex="-1" aria-labelledby="modalPreciosLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalPreciosLabel">Precios del ciclo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @livewire('ciclo.grupo-precio', ['cicloId' => $ciclo->id])
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

{{-- content|end --}}

@endsection