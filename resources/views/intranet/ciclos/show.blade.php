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
                        <p class="card-subtitle">Detalles el ciclo académico</p>
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
                            <label class="control-label text-end col-md-7">Días lectivos:</label>
                            <div class="col-md-5">
                                <p class="form-control-static mb-0">{{ $ciclo->id }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <label class="control-label text-end col-md-7">Ficha socioeconómica:</label>
                            <div class="col-md-5">
                                <p class="form-control-static mb-0">{{ $ciclo->id }}</p>
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
                        <div class="row">
                            <label class="control-label text-end col-md-7">Duración:</label>
                            <div class="col-md-5">
                                <p class="form-control-static mb-0">{{ $ciclo->duracion }} semanas</p>
                            </div>
                        </div>
                    </div>
                    
                </div>

                {{-- <div class="position-relative">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex">
                            <div class="p-8 bg-primary-subtle rounded-2 d-flex align-items-center justify-content-center me-6">
                                <img src="#" alt="" class="img-fluid" width="24" height="24">
                            </div>
                            <div>
                                <h6 class="mb-1 fs-4 fw-semibold">PayPal</h6>
                                <p class="fs-3 mb-0">Big Brands</p>
                            </div>
                        </div>
                        <h6 class="mb-0 fw-semibold">+$6,235</h6>
                    </div>
                </div>
                <button class="btn btn-outline-primary w-100">View all transactions</button> --}}
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
        <div class="card shadow rounded-3">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title fw-semibold">Carreras</h5>
                    </div>
                    <div>
                        <span class="badge fw-semibold py-1 bg-primary-subtle text-primary">
                            <small>{{ count($ciclo->carreras) }}</small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                {{-- {{ $ciclo->carreras }}
                <div class="position-relative">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex">
                            <div
                                class="p-8 bg-primary-subtle rounded-2 d-flex align-items-center justify-content-center me-6">
                                <img src="#" alt="" class="img-fluid" width="24" height="24">
                            </div>
                            <div>
                                <h6 class="mb-1 fs-4 fw-semibold">PayPal</h6>
                                <p class="fs-3 mb-0">Big Brands</p>
                            </div>
                        </div>
                        <h6 class="mb-0 fw-semibold">+$6,235</h6>
                    </div>
                </div> --}}
                <a class="btn btn-outline-primary w-100" href="{{ route('carreras.index') }}">Ver carreras</a>
            </div>
        </div>
    </div>

</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link d-flex active" data-bs-toggle="tab" href="#home2" role="tab"
                                aria-selected="true">
                                <span><i class="ti ti-school fs-4"></i></span>
                                <span class="d-none d-md-block ms-2">Estudiantes</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link d-flex" data-bs-toggle="tab" href="#cicloCarreras" role="tab" aria-selected="false"
                                tabindex="-1">
                                <span><i class="ti ti-network fs-4"></i></span>
                                <span class="d-none d-md-block ms-2">Carreras</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link d-flex" data-bs-toggle="tab" href="#asignaturasTab" role="tab" aria-selected="false"
                                tabindex="-1">
                                <span><i class="ti ti-books"></i></span>
                                <span class="d-none d-md-block ms-2">Asignaturas</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active show" id="home2" role="tabpanel">
                            <div class="p-3">

                                <div class="table-responsive">
                                    <table class="table search-table align-middle text-nowrap table-striped">
                                        <thead class="header-item">
                                            <tr>
                                                <th>Nro Documento</th>
                                                <th>Nombres</th>
                                                <th>Apellidos</th>
                                                <th>Género</th>
                                                <th>Estado Civil</th>
                                                <th>Area</th>
                                                <th>Carrera</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ciclo->matriculas as $matricula)   
                                            <tr class="search-items">
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
                                                    {{-- {{ $matricula->estudiante->genero->descripcion }} --}}
                                                </td>
                                                <td>
                                                    {{-- {{ $matricula->estudiante->estado_civil->descripcion }} --}}
                                                </td>
                                                <td>
                                                    {{-- {{ $matricula->area->descripcion }} --}}
                                                </td>
                                                <td>
                                                    {{-- {{ $matricula->carrera->descripcion }} --}}
                                                </td>
                                                <td>
                                                    <div class="action-btn">
                                                        <a href="javascript:void(0)" class="text-info edit">
                                                            <i class="ti ti-eye fs-5"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" class="text-dark delete ms-2">
                                                            <i class="ti ti-trash fs-5"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                        <div class="tab-pane p-3" id="cicloCarreras" role="tabpanel">
                            <div>
                                <div class="table-responsive">
                                    <table class="table search-table align-middle text-nowrap table-striped">
                                        <thead class="header-item">
                                            <tr>
                                                <th>#</th>
                                                <th>Carrera</th>
                                                <th>Área</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ciclo->carreras as $index => $carrera )   
                                            <tr class="search-items">
                                                <td>
                                                    {{ ($index+1) }}
                                                </td>
                                                <td>
                                                    {{ $carrera->descripcion }}
                                                </td>
                                                <td>
                                                    {{ $carrera->area->descripcion }}
                                                </td>
                                                
                                                <td>
                                                    <div class="action-btn">
                                                        <a href="javascript:void(0)" class="text-info edit">
                                                            <i class="ti ti-eye fs-5"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" class="text-dark delete ms-2">
                                                            <i class="ti ti-trash fs-5"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane p-3" id="asignaturasTab" role="tabpanel">
                            <div>
                                <div class="table-responsive">
                                    {{ $ciclo->asignaturas }}
                                    <table class="table search-table align-middle text-nowrap table-striped">
                                        <thead class="header-item">
                                            <tr>
                                                <th>#</th>
                                                <th>Asignatura</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @foreach ($ciclo->asignaturas as $index => $asignatura )   
                                            <tr class="search-items">
                                                <td>
                                                    {{ ($index+1) }}
                                                </td>
                                                <td>
                                                    {{ $asignatura->descripcion }}
                                                </td>
                                                <td>
                                                    <div class="action-btn">
                                                        <a href="javascript:void(0)" class="text-info edit">
                                                            <i class="ti ti-eye fs-5"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" class="text-dark delete ms-2">
                                                            <i class="ti ti-trash fs-5"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach --}}

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- content|end --}}

@endsection