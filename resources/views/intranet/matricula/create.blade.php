@extends('intranet.layouts.app')

@section('content')

{{-- Breadcrumb|start --}}
<div class="row">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Matrícula</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('ciclos.index') }}">Ciclos</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Nueva matrícula</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Breadcrumb|end --}}


{{-- content|start --}}
<div class="card shadow w-100 position-relative overflow-hidden">
    <div class="card-body p-4">

        <form action="{{ route('matricula.store') }}" method="POST" class="mx-auto bg-white p-8 px-10 shadow-md">
            @csrf

            <div class="row g-4">
                <!-- Datos personales -->
                <div class="row">

                    <input type="hidden" name="ciclo_id" value="{{ $ciclo_id }}">
                    <input type="hidden" name="estudiante_id" value="{{ $estudiante_id }}">

                    <div class="col-md-4 mb-3">
                        <label for="area_id" class="form-label">Área</label>
                        <select name="area_id" id="area_id" class="form-select @error('area_id') is-invalid @enderror" required>
                            <option value="">Seleccionar Área</option>
                            @foreach ($areas as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->descripcion }}
                            </option>
                            @endforeach
                        </select>
                        @error('area_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="carrera_id" class="form-label">Carrera</label>
                        <select name="carrera_id" id="carrera_id" class="form-select @error('carrera_id') is-invalid @enderror" required>
                            <option value="">Seleccionar Carrera</option>
                        </select>
                        @error('carrera_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="sede_id" class="form-label">Sede</label>
                        <select name="sede_id" id="sede_id" class="form-select @error('sede_id') is-invalid @enderror" required>
                            @foreach ($sedes as $sede)
                            <option value="{{ $sede->id }}">
                                {{ $sede->descripcion }}
                            </option>
                            @endforeach
                        </select>
                        @error('sede_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="aula_ciclo_id" class="form-label">Aula</label>
                        <select name="aula_ciclo_id" id="aula_ciclo_id" class="form-select @error('aula_ciclo_id') is-invalid @enderror" required>
                            @foreach ($ciclo->aulas_ciclos as $aula)
                            <option value="{{ $aula->id }}">
                                {{ $aula->aula->descripcion }}
                            </option>
                            @endforeach
                        </select>
                        @error('aula_ciclo_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="forma_de_pago_id" class="form-label">Modalidad de pago</label>
                        <select name="forma_de_pago_id" id="forma_de_pago_id" class="form-select @error('forma_de_pago_id') is-invalid @enderror" required>
                            @foreach ($formasDePago as $modalidad)
                            <option value="{{ $modalidad->id }}">
                                {{ $modalidad->descripcion }}
                            </option>
                            @endforeach
                        </select>
                        @error('forma_de_pago_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="banco_id" class="form-label">Banco</label>
                        <select name="banco_id" id="banco_id" class="form-select @error('banco_id') is-invalid @enderror" required>
                            @foreach ($bancos as $banco)
                            <option value="{{ $banco->id }}">
                                {{ $banco->descripcion }}
                            </option>
                            @endforeach
                        </select>
                        @error('banco_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fecha_pago" class="form-label">Fecha de pago</label>
                        <input name="fecha_pago" type="date" id="fecha_pago" class="form-control @error('fecha_pago') is-invalid @enderror" required value="{{ date('Y-m-d') }}" />
                        @error('fecha_pago')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="cod_operacion" class="form-label">Código de operación</label>
                        <input name="cod_operacion" type="text" id="cod_operacion" class="form-control @error('cod_operacion') is-invalid @enderror" required
                            autocomplete="off" />
                        @error('cod_operacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="descripcion_pago" class="form-label">Descripción del pago</label>
                        <input name="descripcion_pago" type="text" id="descripcion_pago" class="form-control @error('descripcion_pago') is-invalid @enderror"
                            value="MATRÍCULA CEPRE UNH - {{ mb_strtoupper($ciclo->descripcion) }}" required autocomplete="off"
                            oninput="this.value = this.value.toUpperCase();" />
                        @error('descripcion_pago')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="n_transaccion" class="form-label">Número de transacción</label>
                        <input name="n_transaccion" type="text" id="n_transaccion" class="form-control @error('n_transaccion') is-invalid @enderror" required
                            autocomplete="off" oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                        @error('n_transaccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="monto" class="form-label">Monto</label>
                        <input name="monto" type="number" id="monto" class="form-control @error('monto') is-invalid @enderror" required
                            autocomplete="off" />
                        @error('monto')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="comision" class="form-label">Comisión</label>
                        <input name="comision" type="number" id="comision" class="form-control @error('comision') is-invalid @enderror" required
                            autocomplete="off" />
                        @error('comision')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="monto_neto" class="form-label">Monto neto</label>
                        <input name="monto_neto" type="number" id="monto_neto" class="form-control @error('monto_neto') is-invalid @enderror" required
                            autocomplete="off" />
                        @error('monto_neto')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col text-end">
                        <button type="submit" class="btn btn-primary px-8">Continuar</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Mostrar todos los errores -->
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

    </div>
</div>
{{-- content|end --}}


@endsection

@section('scripts')

<script>
    // Obtener el elemento del select de Área
    const areaSelect = document.getElementById('area_id');
    // Obtener el elemento del select de Carrera
    const carreraSelect = document.getElementById('carrera_id');

    // Cuando cambia el valor del select de área
    areaSelect.addEventListener('change', function() {
        const areaId = this.value;  // Obtener el ID del área seleccionada

        // Limpiar las opciones anteriores de carreras
        carreraSelect.innerHTML = '<option value="">Seleccionar Carrera</option>';

        if (areaId) {
            // Hacer una solicitud AJAX con Fetch para obtener las carreras de esa área
            fetch(`/carreras/${areaId}`)
                .then(response => response.json())
                .then(data => {

                    console.log(data);
                    
                    // Verificar si la respuesta contiene carreras
                    if (data.length > 0) {
                        // Llenar el select de carrera con las opciones obtenidas
                        data.forEach(carrera => {
                            const option = document.createElement('option');
                            option.value = carrera.id;
                            option.textContent = carrera.descripcion;
                            carreraSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error al cargar las carreras:', error);
                });
        }        
    });
</script>

@endsection