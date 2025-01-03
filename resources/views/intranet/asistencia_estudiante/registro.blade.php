@extends('intranet.layouts.app')


@section('css')
    <style>    
        #reloj {
            font-size: 3rem;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 15px;
            background-color: #34495e;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 320px;
            margin: 0 auto;
        }
    
        .ampm {
            font-size: 1.2rem;
            color: #f39c12;
        }
    </style>
@endsection

@section('content')

{{-- Breadcrumb|start --}}
<div class="row">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
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
                <div class="col-12 col-md-6">
                    <div class="text-end">
                        <div id="reloj"></div>
                    </div>
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
            @can('asistencia.crear')
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6">

                        <div class="card mt-2">
                            <div class="card-body">
                                <form id="form_marcar_asistencia">
                                    <div class="form-group">
                                        <label class="mb-1" for="ciclo_id">Seleccione ciclo académico</label>
                                        <select class="form-select" id="ciclo_id">
                                            @foreach ($ciclos as $ciclo)
                                            <option value="{{ $ciclo->id }}">{{ $ciclo->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mt-4">
                                        <div id="input_dni_message" class="alert alert-warning d-none" role="alert">
                                            <p>
                                                No se pueden registrar asistencias fuera del horario establecido
                                            </p>
                                            <div>
                                                <p class="mb-0">
                                                    <span>Horario para PRESENTE:</span>
                                                    <span id="horario_presente"></span>
                                                </p>
                                                <p class="mb-0">
                                                    <span>Horario para TARDE:</span>
                                                    <span id="horario_tarde"></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div id="input_dni_estudiante" class="d-none">
                                            <label class="mb-1">Escribe el DNI del estudiante para marcar su asistencia</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control form-control-lg" id="dni_estudiante" name="dni_estudiante"
                                                    placeholder="Escribe el DNI" autocomplete="off" maxlength="8" autofocus="true"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                <button class="btn btn-primary bg-primary-subtle text-primary font-medium" type="submit" id="btn_send_form">
                                                    <i class="ti ti-send-2"></i>
                                                </button>
                                            </div>
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

                                <div class="alert alert-info mt-2 d-none" id="asistencia_detail">

                                    <h5 class="text-center">
                                        <strong id="asistencia_estado"></strong>
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
            @endcan
        </div>
    </div>
</div>

{{-- content|end --}}

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let ESTADO_MARCACION = 0;
        let habilitarInputPresenteDesde_seconds = null;
        let habilitarInputPresenteHasta_seconds = null;
        let habilitarInputTardeDesde_seconds = null;
        let habilitarInputTardeHasta_seconds = null;
        
        let habilitarInputPresenteDesde_time = '';
        let habilitarInputPresenteHasta_time = '';
        let habilitarInputTardeDesde_time = '';
        let habilitarInputTardeHasta_time = '';

        obtenerHorarioDelCiclo();

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
                    minute: '2-digit', second: '2-digit' });

                    $('#success_message').removeClass('d-none').addClass('d-block').text(response.message ?? 'Asistencia registrada correctamente');

                    $('#asistencia_detail').removeClass('d-none').addClass('d-block');
                    
                    $('#fecha_entrada').text(fecha_entrada_formatted);

                    $('#nro_documento_estudiante').text(response.estudiante.nro_documento);
                    $('#nombre_estudiante').text(response.estudiante.nombres);
                    $('#apellidos_estudiante').text(response.estudiante.apellido_paterno + ' ' + response.estudiante.apellido_materno);
                    $('#matricula_area').text(response.matricula.area.descripcion);
                    $('#matricula_carrera').text(response.matricula.carrera.descripcion);

                    if (response.asistencia.estado === 1) {
                        $('#asistencia_estado').text('PRESENTE');
                    } else if (response.asistencia.estado === 2) {
                        $('#asistencia_estado').text('TARDE');
                    } else if (response.asistencia.estado === 3) {
                        $('#asistencia_estado').text('FALTA (fuera de horario)');
                    }else {
                        $('#asistencia_estado').text('Error');
                    }
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
                    $('#dni_estudiante')[0].select();
                }
            });
            
        });

        // Obtener Horario según el ciclo
        $('#ciclo_id').on('change', function() {
            $('#input_dni_message').removeClass('d-block').addClass('d-none');
            $('#input_dni_estudiante').removeClass('d-block').addClass('d-none');
            
            resetearValores();
            obtenerHorarioDelCiclo();
        });

        function resetearValores(){
            ESTADO_MARCACION = 0;
            habilitarInputPresenteDesde_seconds = null;
            habilitarInputPresenteHasta_seconds = null;
            habilitarInputTardeDesde_seconds = null;
            habilitarInputTardeHasta_seconds = null;

            habilitarInputPresenteDesde_time = null;
            habilitarInputPresenteHasta_time = null;
            habilitarInputTardeDesde_time = null;
            habilitarInputTardeHasta_time = null;
        }

        function obtenerHorarioDelCiclo(){
            const ciclo_id = $('#ciclo_id').val();

            resetearValores();
            
            $('#error_message').removeClass('d-block').addClass('d-none').text('');
            $('#success_message').removeClass('d-block').addClass('d-none').text('');
            
            $.ajax({
                url: '/ciclos/' + ciclo_id + '/horario',
                type: 'GET',
                dataType: 'json',
                
                success: function(response) {
                    const horario = response.horario_de_estudiantes;

                    habilitarInputPresenteDesde_time = horario.presente_inicio;
                    habilitarInputPresenteHasta_time = horario.presente_fin;
                    habilitarInputTardeDesde_time = horario.tarde_inicio;
                    habilitarInputTardeHasta_time = horario.tarde_fin;
                    
                    // Convertir los horarios de presente y tarde a segundos desde medianoche
                    const presenteInicio = convertToSeconds(horario.presente_inicio);
                    const presenteFin = convertToSeconds(horario.presente_fin);
                    const tardeInicio = convertToSeconds(horario.tarde_inicio);
                    const tardeFin = convertToSeconds(horario.tarde_fin);

                    habilitarInputPresenteDesde_seconds = presenteInicio;
                    habilitarInputPresenteHasta_seconds = presenteFin;
                    habilitarInputTardeDesde_seconds = tardeInicio;
                    habilitarInputTardeHasta_seconds = tardeFin;
                },
                error: function(xhr) {
                    $('#error_message').removeClass('d-none').addClass('d-block').text(xhr.responseJSON.error);
                },
            });
        }

        function verificarDisponibilidadParaMarcar(){
            const now = new Date();
            const currentTime = now.getHours() * 60 * 60 + now.getMinutes() * 60 + now.getSeconds();

            if (currentTime >= habilitarInputPresenteDesde_seconds && currentTime <= habilitarInputPresenteHasta_seconds) {
                ESTADO_MARCACION = 1;
            } else if (currentTime >= habilitarInputTardeDesde_seconds && currentTime <= habilitarInputTardeHasta_seconds) {
                ESTADO_MARCACION = 2;
            } else {
                ESTADO_MARCACION = 0;
            }
        }

        function actualizarEstadoDeMarcacion() {
            verificarDisponibilidadParaMarcar();
            habilitarInput();
        }

        function habilitarInput() {
            if (ESTADO_MARCACION === 1 || ESTADO_MARCACION === 2) {
                $('#input_dni_message').removeClass('d-block').addClass('d-none');
                $('#input_dni_estudiante').removeClass('d-none').addClass('d-block');
                
            } else {
                $('#input_dni_message').removeClass('d-none').addClass('d-block');
                $('#input_dni_estudiante').removeClass('d-block').addClass('d-none');

                $('#horario_presente').text(habilitarInputPresenteDesde_time + ' - ' + habilitarInputPresenteHasta_time);
                $('#horario_tarde').text( habilitarInputTardeDesde_time + ' - ' + habilitarInputTardeHasta_time);
            }
        }


        function convertToSeconds(time) {
            let parts = time.split(':');
            let hoursInSeconds = parseInt(parts[0]) * 3600; // Convertir horas a segundos
            let minutesInSeconds = parseInt(parts[1]) * 60; // Convertir minutos a segundos
            let seconds = parseInt(parts[2]); // Segundos
            return hoursInSeconds + minutesInSeconds + seconds;
        }
        
        
        // RELOJ
        function actualizarReloj() {
            const ahora = new Date();
            let horas = ahora.getHours();
            const minutos = String(ahora.getMinutes()).padStart(2, '0');
            const segundos = String(ahora.getSeconds()).padStart(2, '0');
            let ampm = "AM";
            
            // Convertir la hora a formato de 12 horas
            if (horas >= 12) {
                ampm = "PM";
            }
            horas = horas % 12;
            horas = horas ? horas : 12; // La hora 0 debe ser 12
        
            // Mostrar la hora en formato 12 horas (hh:mm:ss AM/PM)
            document.getElementById('reloj').innerHTML = `${horas}:${minutos}:${segundos} <span class="ampm">${ampm}</span>`;

            actualizarEstadoDeMarcacion();
            
            if (ESTADO_MARCACION === 1) {
                document.getElementById('reloj').style.border = "3px solid rgb(8, 176, 50)";
            } else if (ESTADO_MARCACION === 2) {
                document.getElementById('reloj').style.border = "3px solid rgb(255, 98, 0)";
            }else{
                document.getElementById('reloj').style.border = 'none';
            }

        }
    
        // Llamar a la función cada segundo (1000 ms)
        setInterval(actualizarReloj, 1000);
    
        // Ejecutar la función inmediatamente al cargar la página
        actualizarReloj();
    });

</script>
@endsection