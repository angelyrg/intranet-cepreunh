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
                    <h5 class="card-title">Reporte de Asistencia</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <!-- Formulario de filtros -->
                        <form method="GET" action="{{ route('asistencia_estudiante.reporte') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="ciclo_id">Ciclo</label>
                                    <select name="ciclo_id" class="form-control">
                                        <option value="">Seleccionar Ciclo</option>
                                        @foreach($ciclos as $ciclo)
                                        <option value="{{ $ciclo->id }}" {{ request('ciclo_id')==$ciclo->id ? 'selected' : '' }}>
                                            {{ $ciclo->descripcion }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                        
                                <div class="col-md-4">
                                    <label for="carrera_id">Carrera</label>
                                    <select name="carrera_id" class="form-control">
                                        <option value="">Seleccionar Carrera</option>
                                        {{-- @foreach($estudiantes as $estudiante)
                                        <option value="{{ $estudiante->carrera_id }}" {{ request('carrera_id')==$estudiante->carrera_id ?
                                            'selected' : '' }}>
                                            {{ $estudiante->carrera->descripcion }}
                                        </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                        
                                {{-- <div class="col-md-4">
                                    <label for="area_id">Área</label>
                                    <select name="area_id" class="form-control">
                                        <option value="">Seleccionar Área</option>
                                        @foreach($estudiantes as $estudiante)
                                        <option value="{{ $estudiante->area_id }}" {{ request('area_id')==$estudiante->area_id ? 'selected' : ''
                                            }}>
                                            {{ $estudiante->area->descripcion }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                            </div>
                        
                            <button type="submit" class="btn btn-primary mt-3">Filtrar</button>
                        </form>
                        
                        <!-- Mostrar los resultados -->
                        <div class="mt-5">
                            <h3>Resultados de Asistencias</h3>
                        
                            <div class="table-responsive"> 

                                <table class="table table-sm" id="asistenciaTable">
                                    <thead>
                                        <tr>
                                            <th>DNI</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Carrera</th>
                                            <th>Área</th>
                                            <th>Hora de Entrada</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($asistencias as $asistencia)
                                        <tr>
                                            <td>{{ $asistencia->estudiante->nro_documento }}</td>
                                            <td>{{ $asistencia->estudiante->nombres }}</td>
                                            <td>{{ $asistencia->estudiante->apellido_paterno . " " . $asistencia->estudiante->apellido_materno }}</td>
                                            <td>{{ $asistencia->matricula->carrera->descripcion }}</td>
                                            <td>{{ $asistencia->matricula->area->descripcion }}</td>
                                            <td>{{ $asistencia->entrada }}</td>
                                            <td>{{ $asistencia->estado == 1 ? 'Presente' : $asistencia->estado }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7">No se encontraron resultados</td>
                                        </tr>
                                        @endforelse
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

{{-- content|end --}}

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#asistenciaTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            },
            "responsive": true, // Hacer la tabla responsive
            "paging": true,     // Habilitar paginación
            "searching": true,  // Habilitar búsqueda
            "ordering": true,   // Habilitar ordenación
            "info": true        // Mostrar información de la tabla
        });
    });
</script>