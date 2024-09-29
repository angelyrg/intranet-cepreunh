@extends('intranet.layouts.app')

@section('content')

    {{-- Breadcrumb|start  --}}
    <div class="row">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">{{ $page }}</h4>
                    <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="../main/index.html">Administración</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                    </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center" id="btnActionGeneral">
                    <button type="button" class="btn btn-primary btnAdd{{ $title }}">
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
            <table class="table text-nowrap mb-0 align-middle" id="tbl{{ $page }}">
            <thead class="text-dark fs-4">
                <tr>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">ACCIONES</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">ESTADO</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">APELLIDOS</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">NOMBRES</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">GRADO ACADÉMICO</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">GÉNERO</h6>
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

    {{-- modal|docentes|atart --}}
    <div id="modal{{ $title }}" class="modal fade" tabindex="-1" aria-labelledby="modal{{ $title }}Label" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary text-white">
                    <h4 class="modal-title text-white" id="modal{{ $title }}Label">Formulario de registro</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <form id="form{{ $title }}" method="POST" action="{{ route('docentes.store') }}">
                    @csrf
                    <input type="hidden" name="id" id="inputId">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">                            
                                <div class="mb-4">
                                    <label for="inputApellidos" class="form-label">Apellidos</label>
                                    <input type="text" name="apellidos" id="inputApellidos" class="form-control" value="">
                                </div>
                            </div>
                            <div class="col-lg-6"> 
                                <div class="mb-4">
                                    <label for="inputNombres" class="form-label">Nombres</label>
                                    <input type="text" name="nombres" id="inputNombres" class="form-control" value="">
                                </div>
                            </div>
                            <div class="col-lg-6"> 
                                <div class="mb-4 form-group">
                                    <label for="inputGradoacademico" class="form-label">Grado académico</label>
                                    <select name="gradoacademico_id" id="inputGradoacademico" class="form-select" aria-label="Default select">
                                        <option value="" selected="">Seleccione</option>
                                        @foreach ($gradoacademico as $item)
                                        <option value="{{ $item->id }}">{{ $item->descripcion }}</option>                                        
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6"> 
                                <div class="mb-4 form-group">
                                    <label for="inputGenero" class="form-label">Género</label>
                                    <select name="genero" id="inputGenero" class="form-select" aria-label="Default select">
                                        <option value="" selected="">Seleccione</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                        
                                    </select>
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
    {{-- modal|docentes|end --}}
    
@endsection
    
@section('scripts')

    {{-- my custom js --}}
    <script src="{{ asset('assets/js/tools.js') }}"></script>
    <script src="{{ asset('assets/js/docentes.js') }}"></script>

@endsection