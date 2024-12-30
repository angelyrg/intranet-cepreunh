@extends('intranet.layouts.app')


@section('content')

{{-- Breadcrumb|start --}}
<div class="row">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Información detallada del estudiante</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('estudiante.index') }}">Estudiantes</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Detalles</li>
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
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title">Datos personales</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">DNI</dt>
                    <dd class="col-sm-9">{{ $estudiante->nro_documento }}</dd>

                    <dt class="col-sm-3">Nombre Completo</dt>
                    <dd class="col-sm-9">{{ $estudiante->nombres }} {{ $estudiante->apellido_paterno }} {{
                        $estudiante->apellido_materno }}</dd>
                    
                    <dt class="col-sm-3">Edad</dt>
                    <dd class="col-sm-9">{{ \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->age }}</dd>

                    <dt class="col-sm-3">Fecha de Nacimiento</dt>
                    <dd class="col-sm-9">{{ \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->format('d/m/Y') }}
                    </dd>

                    <dt class="col-sm-3">Género</dt>
                    <dd class="col-sm-9">{{ $estudiante->genero->descripcion }}</dd>

                    <dt class="col-sm-3">Estado Civil</dt>
                    <dd class="col-sm-9">{{ $estudiante->estado_civil->descripcion }}</dd>

                    <dt class="col-sm-3">Teléfono</dt>
                    <dd class="col-sm-9">{{ $estudiante->telefono_personal }}</dd>

                    <dt class="col-sm-3">WhatsApp</dt>
                    <dd class="col-sm-9">{{ $estudiante->whatsapp }}</dd>

                    <dt class="col-sm-3">Correo Personal</dt>
                    <dd class="col-sm-9">{{ $estudiante->correo_personal }}</dd>

                    <dt class="col-sm-3">Correo Institucional</dt>
                    <dd class="col-sm-9">{{ $estudiante->correo_institucional ?? 'No disponible' }}</dd>

                    <dt class="col-sm-3">Dirección</dt>
                    <dd class="col-sm-9">{{ $estudiante->direccion }}</dd>

                    <dt class="col-sm-3">Sede Actual</dt>
                    <dd class="col-sm-9">{{ $estudiante->sede_actual->descripcion }}</dd>

                    <dt class="col-sm-3">Estado</dt>
                    <dd class="col-sm-9">
                        @if($estudiante->estado == 1)
                        Activo
                        @else
                        Inactivo
                        @endif
                    </dd>

                    <dt class="col-sm-3">Fecha de registro</dt>
                    <dd class="col-sm-9">{{ \Carbon\Carbon::parse($estudiante->created_at)->format('d/m/Y h:i:sA') }}</dd>
                </dl>                
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title">Matrículas</h5>
            </div>
            <div class="card-body">
                @if($estudiante->matriculas->isEmpty())
                <p>No tiene matrículas registradas.</p>
                @else
                <ul class="list-group gap-2">
                    @foreach($estudiante->matriculas as $matricula)
                    <li class="list-group-item rounded-3 border shadow p-3">
                        <div class="row">
                            <div class="col-12 col-md-6 d-flex flex-column justify-content-between">
                                <div>
                                    <strong>ID:</strong> {{ $matricula->id }} <br>
                                    <strong>Ciclo:</strong> {{ $matricula->ciclo->descripcion }} <br>
                                    <strong>Área:</strong> {{ $matricula->area->descripcion }} <br>
                                    <strong>Carrera:</strong> {{ $matricula->carrera->descripcion }} <br>
                                    <strong>Modalidad de Estudio:</strong> {{ $matricula->modalidad_estudio }} <br>
                                    <strong>Condición Académica:</strong> {{ $matricula->condicion_academica }} <br>
                                    <strong>Aula:</strong> {{ $matricula->aula_actual->descripcion ?? 'No asignado' }} <br>
                                    <strong>Fecha de matrícula:</strong> {{ \Carbon\Carbon::parse($matricula->created_at)->format('d/m/Y h:i:sA') }}
                                    <br>
                                    <strong>Modalidad de matrícula:</strong> 
                                    @if($matricula->modalidad_matricula == 1)
                                        Presencial
                                    @elseif($matricula->modalidad_matricula == 2)
                                        Virtual
                                    @else
                                        Otro
                                    @endif
                                </div>
                                <div>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-outline-danger btnDelete"
                                            data-id="{{ $matricula->id }}">Eliminar</button>
                                        <a href="{{ route('matricula.edit', $matricula->id) }}" class="btn btn-sm btn-outline-primary">
                                            Editar
                                        </a>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12 col-md-6">
                                <div class="bagde bg-info-subtle p-3 rounded-end-3">
                                    <strong class="text-priimary">PAGOS</strong>
                                    @foreach ($matricula->pagos as $pago)
                                        <div class="border border-dashed border-dark rounded-1 px-2 py-1">
                                            <strong>N° Transacción: </strong> {{ $pago->n_transaccion }} <br>
                                            <strong>Descripción: </strong> {{ $pago->descripcion_pago }} <br>
                                            <strong>Cod Operación: </strong> {{ $pago->cod_operacion }} <br>
                                            <strong>Banco: </strong> {{ $pago->banco->descripcion }} <br>
                                            <strong>Monto: </strong> S/{{ $pago->monto }} <br>
                                            <strong>Comisión: </strong> S/{{ $pago->comision }} <br>
                                            <strong>Monto Neto: </strong> S/{{ $pago->monto }} <br>
                                            <strong>Fecha de pago: </strong>{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }} <br>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        {{-- <a href="{{ route('matriculas.show', $matricula->id) }}" class="btn btn-info btn-sm mt-2">Ver Detalles de
                            la Matrícula</a> --}}
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script src="{{ asset('assets/js/tools.js') }}"></script>

<script>
    document.querySelectorAll('.btnDelete').forEach(button => {
        button.addEventListener('click', function() {
            const matriculaId = this.getAttribute('data-id');
            
            // Mostrar la alerta de confirmación con SweetAlert2
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta matrícula será eliminada permanentemente.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, enviar el formulario de eliminación
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('matricula.delete', ':matricula') }}'.replace(':matricula', matriculaId);

                    // Crear el token CSRF
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);
                    
                    // Agregar el método DELETE
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);
                    
                    // Enviar el formulario
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>

@endsection