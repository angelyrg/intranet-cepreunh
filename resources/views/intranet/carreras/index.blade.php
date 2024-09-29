@extends('intranet.layouts.app')

@section('content')

    {{-- Breadcrumb|start  --}}
    <div class="row">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Carreras profesionales</h4>
                    <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="../main/index.html">Administración</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Carreras</li>
                    </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center" id="btnActionGeneral">
                    {{-- <button type="button" id="btnAddCarrera" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCarrera"> --}}
                    <button type="button" class="btn btn-primary btnAddCarrera">
                        <i class="ti ti-books fs-4"></i> NUEVO REGISTRO
                    </button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    {{-- Breadcrumb|end  --}}

    {{-- content|start --}}
    <div class="card w-100 position-relative overflow-hidden">
        <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">Listado de registros</h4>
        </div>
        <div class="card-body p-4">
        <div class="table-responsive mb-4 border rounded-1">
            <table class="table text-nowrap mb-0 align-middle" id="tblCarreras">
            <thead class="text-dark fs-4">
                <tr>
                <th>
                    <h6 class="fs-4 fw-semibold mb-0">ACCIONES</h6>
                </th>
                <th>
                    <h6 class="fs-4 fw-semibold mb-0">ESTADO</h6>
                </th>
                <th>
                    <h6 class="fs-4 fw-semibold mb-0">ÁREA</h6>
                </th>
                <th class="w-60">
                    <h6 class="fs-4 fw-semibold mb-0">CARRERAS</h6>
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

    {{-- modal|carreras|atart --}}
    <div id="modalCarrera" class="modal fade" tabindex="-1" aria-labelledby="modalCarreraLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary text-white">
                    <h4 class="modal-title text-white" id="modalCarreraLabel">
                    Formulario de registro
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <form id="formCarrera" method="POST" action="{{ route('carreras.store')}}">
                    @csrf
                    {{-- {{ csrf_field() }} --}}
                    <input type="hidden" name="id" id="inputId">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">                            
                                <div class="mb-4">
                                    <label for="inputArea" class="form-label">Área</label>
                                    <select name="area_id" id="inputArea" class="form-select" aria-label="Default select">
                                        <option value="" selected="">Seleccione</option>
                                        @foreach ($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="mb-4">
                                    <label for="inputCarrera" class="form-label">Carrera</label>
                                    <input type="text" name="descripcion" class="form-control" id="inputCarrera" placeholder="Ingrese">
                                </div> --}}
                                <div class="mb-4 form-group">
                                    <label for="inputCarrera" class="form-label">Descripción</label>
                                    <input type="text" name="descripcion" id="inputCarrera" class="form-control" value="{{ old('descripcion') }}">
                                    {{-- @if ($errors->has('descripcion'))
                                        <div class="alert alert-danger">{{ $errors->first('descripcion') }}</div>
                                    @endif --}}
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
    {{-- modal|carreras|end --}}
    
@endsection
    
@section('scripts')

    {{-- my custom js --}}
    <script src="{{ asset('assets/js/tools.js') }}"></script>
    <script src="{{ asset('assets/js/carreras.js') }}"></script>

@endsection