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
                    <h5 class="card-title">Asistencia</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                
                                <form class="mt-3" id="form_marcar_asistencia">
                                    <div class="form-group">
                                        <label for="ciclo_id">Seleccione ciclo académico</label>
                                        <select class="form-select" id="ciclo_id">
                                            @foreach ($ciclos as $ciclo)
                                            <option value="{{ $ciclo->id }}">{{ $ciclo->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="mt-4">
                                        <label>Escribe el DNI para marcar la asistencia</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control form-control-lg" id="dni_estudiante"
                                                name="dni_estudiante" placeholder="Escribe el DNI" autocomplete="off"
                                                maxlength="8" autofocus="true"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            <button class="btn btn-primary bg-primary-subtle text-primary font-medium" type="submit" id="btn_send_form">
                                                <i class="ti ti-send-2"></i>
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="spinner-grow d-none" role="status" id="loading_spinner">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                                <div id="error_message" class="alert alert-danger mb-0 d-none" role="alert"></div>
                                <div id="success_message" class="alert alert-success mb-0 d-none" role="alert"></div>

                                <div class="alert alert-success mt-2 d-none" id="asistencia_detail">

                                    <h5 class="text-center">
                                        <span>Entrada:</span>
                                        <br>
                                        <strong id="fecha_entrada"></strong>
                                    </h5>

                                    <p class="mb-0"><strong>DNI:</strong> <span id="nro_documento_estudiante"></span></p>
                                    <p class="mb-0"><strong>Nombres:</strong> <span id="nombre_estudiante"></span></p>
                                    <p class="mb-0"><strong>Apellidos:</strong> <span id="apellidos_estudiante"></span></p>
                                    <p class="mb-0"><strong>Área:</strong> <span id="matricula_area"></span></p>
                                    <p class="mb-0"><strong>Carrera:</strong> <span id="matricula_carrera"></span></p>
                                </div>

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
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const formAsistencia = $("#form_marcar_asistencia");
        const dniInput = $("#dni_estudiante");

        // Agrega un evento para detectar cuando se escriban 8 dígitos
        dniInput.on("input", function () {
            if (this.value.length === 8) {
                formAsistencia.submit();
            }
        });

        //Buscar estudiante
       formAsistencia.on('submit', function(e) {
            e.preventDefault();

            $('#loading_spinner').removeClass('d-none').addClass('d-block');
            $('#asistencia_detail').removeClass('d-block').addClass('d-none');
            $('#btn_send_form').prop('disabled', true);

            const ciclo_id = $('#ciclo_id').val();
            const dni = $('#dni_estudiante').val();

            console.log(ciclo_id, dni);
  
            
            $.ajax({
                url: '/asistencia/store',
                type: 'POST',
                data: {
                    dni_estudiante: dni,
                    ciclo_id: ciclo_id,
                },
                dataType: 'json',
                beforeSend: function() {                    
                    $('#error_message').removeClass('d-block').addClass('d-none').text('');
                    $('#success_message').removeClass('d-block').addClass('d-none').text('');
                },
                success: function(response) {
                    const fecha_entrada = new Date(response.asistencia.entrada);
                    const fecha_entrada_formatted = fecha_entrada.toLocaleString('es-PE', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit',
                    minute: '2-digit' });

                    $('#success_message').removeClass('d-none').addClass('d-block').text(response.message ?? 'Asistencia registrada correctamente');

                    $('#asistencia_detail').removeClass('d-none').addClass('d-block');
                    
                    $('#fecha_entrada').text(fecha_entrada_formatted);

                    $('#nro_documento_estudiante').text(response.estudiante.nro_documento);
                    $('#nombre_estudiante').text(response.estudiante.nombres);
                    $('#apellidos_estudiante').text(response.estudiante.apellido_paterno + ' ' + response.estudiante.apellido_materno);
                    $('#matricula_area').text(response.matricula.area.descripcion);
                    $('#matricula_carrera').text(response.matricula.carrera.descripcion);
                },
                error: function(xhr) {
                    console.error(xhr);
                    
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
                    $('#loading_spinner').removeClass('d-block').addClass('d-none');
                    $('#btn_send_form').prop('disabled', false);
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
                                <td>${ entrega.estado == 1 ? 'Entregado' : entrega.estado }</td>
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