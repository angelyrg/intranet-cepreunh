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
                            <i class="ti ti-books fs-4"></i> NUEVO REGISTRO
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
                            <h6 class="fs-4 fw-semibold mb-0">AULA</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">PISO</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">AFORO</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">SEDE</h6>
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

{{-- modal|aulas|start --}}
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
                <form id="form{{ $slug }}" method="POST" action="{{ route('aulas.store') }}" novalidate>
                    @csrf
                    <input type="hidden" name="id" id="id">
    
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-4">
                                    <label for="sede_id" class="form-label">Sede</label>
                                    <div class="controls">
                                            <select name="sede_id" id="sede_id" class="form-select" aria-label="Sede select">
                                            <option value="" selected="">Seleccione</option>
                                            @foreach ($sedes as $sede)
                                            <option value="{{ $sede->id }}">{{ $sede->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-4 form-group">
                                    <label for="descripcion" class="form-label">Nombre del aula</label>
                                    <div class="controls">
                                        <input type="text" name="descripcion" id="descripcion" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-4 form-group">
                                    <label for="piso" class="form-label">Piso</label>
                                    <div class="controls">
                                        <input type="number" name="piso" id="piso" value="1" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-4 form-group">
                                    <label for="aforo" class="form-label">Aforo</label>
                                    <div class="controls">
                                        <input type="number" name="aforo" id="aforo" value="30" class="form-control" autocomplete="off">
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
{{-- modal|aulas|end --}}

@endsection

@section('scripts')

{{-- my custom js --}}
<script src="{{ asset('assets/js/tools.js') }}"></script>
<script src="{{ asset('assets/js/aulas.js') }}"></script>

@endsection