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
                                <a class="text-muted text-decoration-none" href="{{ route('ciclos.index') }}">Ciclos</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('ciclos.show', $ciclo->id) }}">{{ $ciclo->descripcion }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Breadcrumb|end --}}


{{-- content|start --}}
<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"></h4>
    </div>
    <div class="card-body p-4">
        <div id="validacion_dni">
            {{-- TODO: Usar JS para llada asincrona --}}
            <form action="{{ route('matricula.buscar_dni') }}" method="POST">
                @csrf
                <input type="hidden" name="ciclo_id" value="{{ $ciclo->id }}">
                @if(session()->has('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
                @endif

                <div class="form-group mb-4">
                    <label for="estudiante_dni">DNI del estudiante <span class="text-danger">*</span></label>
                    <input name="estudiante_dni" type="text" maxlength="8" class="form-control"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" autocomplete="off"
                        value="{{ old('estudiante_dni') }}" required >
                </div>                

                <button class="btn btn-primary" type="submit">
                    Continuar
                </button>

            </form>
        </div>
    </div>
</div>
{{-- content|end --}}


@endsection

@section('scripts')

{{-- my custom js --}}
{{-- <script src="{{ asset('assets/js/tools.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/matricula.js') }}"></script> --}}

@endsection