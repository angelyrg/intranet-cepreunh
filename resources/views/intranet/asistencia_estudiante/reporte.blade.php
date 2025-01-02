@extends('intranet.layouts.app')

@section('content')

{{-- Breadcrumb|start --}}
<div class="row">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <h4 class="fw-semibold mb-8">Registro de asistencia de estudiantes</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home</a>
                            </li>

                            <li class="breadcrumb-item active" aria-current="page">Asistencia</li>
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
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Reporte de Asistencia General</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @can('asistencias.lista')
                    <div class="col-12">
                        <livewire:estudiante.reporte-asistencia-table sedeId="{{ $sedeId }}" />
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>

{{-- content|end --}}

@endsection
