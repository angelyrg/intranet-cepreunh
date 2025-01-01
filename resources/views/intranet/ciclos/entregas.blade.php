@extends('intranet.layouts.app')

@section('content')

{{-- Breadcrumb|start --}}
<div class="row">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <h4 class="fw-semibold mb-8">Entrega de materiales</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('ciclos.index') }}">Ciclos</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none"
                                    href="{{ route('ciclos.show', $ciclo->id) }}">{{ $ciclo->descripcion }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Entregas</li>
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
                    <h5 class="card-title">{{ $ciclo->descripcion }} > Entregas</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="material_entregable_id">Selecciona el material a entregar</label>
                                    <select class="form-select" id="material_entregable_id">
                                        @foreach ($materiales_entregables as $material)
                                            <option value="{{ $material->id }}">{{ $material->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                
                                <form class="mt-3" id="form_search_estudiante">

                                    <input type="hidden" id="ciclo_id" name="ciclo_id" value="{{ $ciclo->id }}">

                                    <label>Buscar estudiante</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="dni_estudiante" name="dni_estudiante"
                                            placeholder="Escribe el DNI"
                                            autocomplete="off"
                                            maxlength="8"
                                            autofocus="true"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        <button class="btn bg-info-subtle text-info font-medium" type="submit" id="btn_buscar_estudiante">
                                            <i class="ti ti-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div id="error_message" class="alert alert-danger mb-0 d-none" role="alert"></div>
                                <div id="success_message" class="alert alert-success mb-0 d-none" role="alert"></div>
                                <div id="entrega_materiales_container" class="d-none">
                                    <p class="mb-0">Nombres: <span id="nombre_estudiante"></span></p>
                                    <p class="mb-0">Apellidos: <span id="apellidos_estudiante"></span></p>
                                    <p class="mb-0">DNI: <span id="nro_documento_estudiante"></span></p>

                                    @can('entrega.crear')
                                    <form class="mt-3" id="form_entregar_material">
                                        <input type="hidden" name="matricula_id" id="matricula_id" value="">
                                        <input type="hidden" name="sede_id" id="sede_id" value="">
                                        <button class="btn btn-primary" type="submit" id="btn_entregar_material">Entregar material</button>
                                    </form>
                                    @endcan

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('entregas.lista')
    <div class="col-12">
        <div class="card">
            <div class="card-header py-1">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title">Materiales entregados al estudiante</h6>
                </div>
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-striped" id="tblEntregas">
                        <thead>
                            <tr>
                                <th class="text-center">N°</th>
                                <th>Material</th>
                                <th>Fecha de entrega</th>
                            </tr>
                        </thead>
                        <tbody id="tblEntregasBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endcan
</div>
{{-- content|end --}}

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //Buscar estudiante
        $('#form_search_estudiante').on('submit', function(e) {
            e.preventDefault();

            const ciclo_id = $('#ciclo_id').val();
            const dni = $('#dni_estudiante').val();
            const material_id = $('#material_entregable_id').val();           

            $.ajax({
                url: '/entregas/buscar_matricula/' + dni + '/' + ciclo_id,
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $('#nombre_estudiante').text('');
                    $('#apellidos_estudiante').text('');
                    $('#nro_documento_estudiante').text('');
                    $('#btn_buscar_estudiante').html('<i class="ti ti-loader"></i>');
                    $('#entrega_materiales_container').removeClass('d-block').addClass('d-none');
                    $('#error_message').removeClass('d-block').addClass('d-none').text('');
                    $('#tblEntregasBody').empty();
                },
                success: function(response) {
                    const estudiante = response.estudiante;

                    $('#nombre_estudiante').text(estudiante.nombres);
                    $('#apellidos_estudiante').text(estudiante.apellido_materno + ' ' + estudiante.apellido_paterno);
                    $('#nro_documento_estudiante').text(estudiante.nro_documento);
                    $('#matricula_id').val(estudiante.matriculas[0].id);
                    $('#sede_id').val(estudiante.matriculas[0].sede_id);
                    $('#entrega_materiales_container').removeClass('d-none').addClass('d-block');

                    getEntregasByMatricula(estudiante.matriculas[0].id)
                },
                error: function(xhr) {
                    $('#error_message').removeClass('d-none').addClass('d-block').text(xhr.responseJSON.error);
                },
                complete: function() {
                    $('#btn_buscar_estudiante').html('<i class="ti ti-search"></i>');
                }
            });
            
        });


        //Entregar material
        $('#form_entregar_material').on('submit', function(e) {
            e.preventDefault();

            const matricula_id = $('#matricula_id').val();
            const material_entregable_id = $('#material_entregable_id').val();
            const sede_id = $('#sede_id').val();
            const ciclo_id = $('#ciclo_id').val();

            $.ajax({
                url: '/entregas/store',
                type: 'POST',
                data: {
                    material_entregable_id: material_entregable_id,
                    matricula_id: matricula_id,
                    ciclo_id: ciclo_id,
                    sede_id: sede_id,
                },
                dataType: 'json',
                beforeSend: function() {                    
                    $('#btn_entregar_material').html('<i class="ti ti-loader ti-spin"></i> Enviando...').prop('disabled', true);
                    $('#error_message').removeClass('d-block').addClass('d-none').text('');
                    $('#success_message').removeClass('d-block').addClass('d-none').text('');
                },
                success: function(response) {
                    getEntregasByMatricula(matricula_id);
                    $('#success_message').removeClass('d-none').addClass('d-block').text('Material entregado correctamente');
                },
                error: function(xhr) {
                    // Limpiar cualquier mensaje de error previo
                    $('#error_message').removeClass('d-none').addClass('d-block').empty();

                    // Mostrar el error general, si hay
                    if (xhr.responseJSON.error) {
                        $('#error_message').append('<p>' + xhr.responseJSON.error + '</p>');
                    }

                    // Verificar si hay errores específicos de validación
                    const errors = xhr.responseJSON.errors;
                    if (errors) {
                        for (let field in errors) {
                            $('#error_message').append('<p class="mb-0">' + errors[field].join(", ") + '</p>');
                        }
                    }
                },
                complete: function() {
                    $('#btn_entregar_material').html('Entregar Material').prop('disabled', false);
                }

            });
        });

        //Get by Matricula
        function getEntregasByMatricula(matricula_id){
            $.ajax({
                url: '/entregas/byMatricula/' + matricula_id,
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $('#tblEntregasBody').empty();
                },
                success: function(response) {                    
                    const entregas = response.entregas;
                    let html = '';
                    entregas.forEach((entrega, index) => {
                        html += `
                            <tr>
                                <td class="text-center">${index + 1}</td>
                                <td>${entrega.material_entregable.descripcion}</td>
                                <td>${new Date(entrega.created_at).toLocaleString()}</td>
                            </tr>
                        `;
                    });                    
                    $('#tblEntregasBody').html(html);
                }
            });
        }
    });

</script>
@endsection
