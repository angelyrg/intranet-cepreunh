@extends('intranet.layouts.app')

@section('content')

{{-- Breadcrumb|start --}}
<div class="row">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <h4 class="fw-semibold mb-8">Estudiantes</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Gestión académica</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Lista</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Breadcrumb|end --}}

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Estudiantes</h5>
                </div>
            </div>
            <div class="card-body">
                @can('matriculas.lista')
                <livewire:estudiante.estudiantes-table sedeId="{{ $sedeId }}" />
                @endcan
            </div>
        </div>
    </div>
</div>

{{-- @livewire('estudiante.estudiante-list') --}}

@endsection

@section('scripts')
<script src="{{ asset('assets/js/tools.js') }}"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        window.confirmDeleteEstudiante = function(estudianteId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Este estudiante y sus datos asociados serán eliminados. ¿Estás seguro de que deseas continuar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-outline-primary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('delete-estudiante', {estudianteId: estudianteId});
                }
            });
        };
    });
</script>
@endsection