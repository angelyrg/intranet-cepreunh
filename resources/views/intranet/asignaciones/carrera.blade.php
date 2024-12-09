@extends('intranet.layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('modernize/libs/select2/dist/css/select2.min.css')}}">
<style>
    .select2-selection {
        height: 100% !important;
    }
</style>
@endsection


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
                            <a class="text-muted text-decoration-none" href="#">Administración</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                    </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center" id="btnActionGeneral">
                    {{-- <button type="button" class="btn btn-primary btnAdd{{ $title }}">
                        <i class="ti ti-books fs-4"></i> NUEVO REGISTRO
                    </button> --}}
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
            <form id="form{{ $title }}" action="{{ route('carreraciclo.store') }}" method="post">
                <input type="hidden" name="id" value="">
                {{-- <input type="hidden" name="ciclo_id" value="{{ $idciclo }}"> --}}

                <div class="row">
                    <div class="col-md-12 border-bottom">
                        <div class="mb-3">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="inputGroupSelect01">Ciclos académicos</label>
                                <select class="form-select" id="ciclo_id{{ $title }}" name="ciclo_id">
                                    <option>Seleccionar ciclo académico</option>
                                    {!! $sltCicloAcademico !!}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mt-3" style="flex-wrap: nowrap !important">
                            <div class="input-group-text">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input selectAllOptions" id="chkCarreraCiclo" value="check">
                                    <label class="form-check-label" for="chkCarreraCiclo"></label>
                                </div>
                                <span class="txtAllOptions">Seleccionar todo</span> 
                            </div>
                            <select class="form-control select2-icons" placeholder="Seleccionar" multiple="multiple" id="carrera_id{{ $title }}" name="carrera_id[]">
                                {!! $sltCarreras !!}
                            </select>
                            <button type="submit" class="btn btn-primary">AGREGAR</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-4">
            <div class="mb-4 rounded-1">
                <div class="row" id="tbl{{ $title }}">
                    {!! $bloqueArea !!}
                </div>
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
                <form id="form{{ $title }}" method="POST" action="{{ route('asignaturas.store') }}" novalidate >
                    @csrf
                    <input type="hidden" name="id" id="id">
                    
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">                            
                                <div class="mb-4 form-group">
                                    <label for="descripcion{{ $title }}" class="form-label">Descripción</label>
                                    <div class="controls">
                                        <input type="text" name="descripcion" id="descripcion{{ $title }}" class="form-control" value="" required data-validator-required-message="XD" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">                            
                                <div class="mb-4 form-group">
                                    <label for="estado{{ $title }}" class="form-label">Estado</label>
                                    <div class="controls">
                                        <select name="estado" id="estado{{ $title }}" class="form-control" required>
                                            <option value="">Seleccione</option>
                                            <option value="1">ACTIVO</option>
                                            <option value="0">INACTIVO</option>
                                        </select>
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
    {{-- modal|docentes|end --}}
    
@endsection
    
@section('scripts')
    
    <script src="{{ asset('modernize/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('modernize/libs/select2/dist/js/select2.full.min.js') }}"></script>

    {{-- my custom js --}}
    <script src="{{ asset('assets/js/tools.js') }}"></script>
    <script src="{{ asset('assets/js/carreraciclo.js') }}"></script>


@endsection