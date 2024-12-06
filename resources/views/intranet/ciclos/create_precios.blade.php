@extends('intranet.layouts.app')

@section('content')

{{-- TODO: Estandarizar los breadcrumbs --}}
{{-- Breadcrumb|start --}}
<div class="row">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <h4 class="fw-semibold mb-8">Selecionar carreas</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('ciclos.index') }}">Ciclos</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('ciclos.show', $ciclo->id) }}">{{ $ciclo->descripcion }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Configurar precios</li>
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

            </div>
        </div>
    </div>

    <div class="row">
    
        @livewire('ciclo.grupo-precio', ['cicloId' => $ciclo->id])
    
    </div>

</div>


{{-- content|end --}}

@endsection

@section('scripts')
<script>
    function toggleSelectAll() {
        var checkboxes = document.querySelectorAll('.carrera-checkbox');
        var selectAllCheckbox = document.getElementById('select_all');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = selectAllCheckbox.checked;
        });
    }
</script>
@endsection