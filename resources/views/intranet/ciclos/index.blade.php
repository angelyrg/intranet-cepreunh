@extends('intranet.layouts.app')

@section('content')

{{-- Breadcrumb|start --}}
<div class="row">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">{{ $page }}</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="#">Administración</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center" id="btnActionGeneral">
                        <button type="button" class="btn btn-primary btnAdd{{ $slug }}">
                            <i class="ti ti-plus fs-4"></i> NUEVO REGISTRO
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Breadcrumb|end --}}

{{-- content|start --}}
<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">Listado de registros</h4>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1">
            <table class="table text-nowrap mb-0 align-middle" id="tbl{{ $slug }}">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">ACCIONES</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">ESTADO</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">DESCRIPCIÓN</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">INICIO</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">TÉRMINO</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">DURACIÓN</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">TIPO</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">FECHA CREACCIÓN</h6>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {!! $datatable !!}
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- content|end --}}

{{-- modal|ciclos|atart --}}
<div id="modal{{ $slug }}" class="modal fade" tabindex="-1" aria-labelledby="modal{{ $slug }}Label"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary text-white">
                <h4 class="modal-title text-white" id="modal{{ $slug }}Label">Formulario de registro</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <form id="form{{ $slug }}" method="POST" action="{{ route('ciclos.store') }}" novalidate>
                    @csrf
                    <input type="hidden" name="id" id="id">
    
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4 form-group">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <div class="controls">
                                        <input type="text" name="descripcion" id="descripcion" class="form-control" value="Ciclo Académico" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4 form-group">
                                    <label for="tipos_ciclos_id" class="form-label">Tipo</label>
                                    <div class="controls">
                                        <select name="tipos_ciclos_id" id="tipos_ciclos_id" class="form-select" required>
                                            <option value="" selected="" disabled>Seleccione</option>
                                            @foreach ($tipos_ciclos as $item)
                                            <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4 form-group">
                                    <label for="fecha_inicio" class="form-label">Inicio de ciclo</label>
                                    <div class="controls">
                                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4 form-group">
                                    <label for="fecha_fin" class="form-label">Fin del ciclo</label>
                                    <div class="controls">
                                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4 form-group">
                                    <label for="duracion" class="form-label">Duración</label>
                                    <div class="controls">
                                        <div class="input-group mb-3">
                                            <input type="number" name="duracion" id="duracion" class="form-control" value="11" placeholder="Semanas"
                                                aria-describedby="input-duracion">
                                            <span class="input-group-text">Semanas</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4 form-group">
                                    <label for="dias_lectivos" class="form-label">Días Lectivos</label>
                                    <div class="controls">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" name="dias_lectivos[]"
                                                value="1" id="lunes" checked>
                                            <label class="form-check-label" for="lunes">Lunes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" name="dias_lectivos[]"
                                                value="2" id="martes" checked>
                                            <label class="form-check-label" for="martes">Martes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" name="dias_lectivos[]"
                                                value="3" id="miercoles" checked>
                                            <label class="form-check-label" for="miercoles">Miércoles</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" name="dias_lectivos[]"
                                                value="4" id="jueves" checked>
                                            <label class="form-check-label" for="jueves">Jueves</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" name="dias_lectivos[]"
                                                value="5" id="viernes" checked>
                                            <label class="form-check-label" for="viernes">Viernes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" name="dias_lectivos[]"
                                                value="6" id="sabado">
                                            <label class="form-check-label" for="sabado">Sábado</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" name="dias_lectivos[]"
                                                value="7" id="domingo">
                                            <label class="form-check-label" for="domingo">Domingo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn bg-primary-subtle text-primary">REGISTRAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- modal|ciclos|end --}}

@endsection

@section('scripts')

{{-- my custom js --}}
<script src="{{ asset('assets/js/tools.js') }}"></script>
<script src="{{ asset('assets/js/ciclos.js') }}"></script>

@endsection