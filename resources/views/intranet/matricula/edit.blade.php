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
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('ciclos.show', $ciclo->id) }}">
                                    {{ $ciclo->descripcion }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Editar Matrícula</li>
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

        <form action="{{ route('matricula.update', $matricula->id) }}" method="POST" class="mx-auto bg-white p-8 px-10 shadow-md">
            @csrf
            @method('PUT')
        
            <div class="row g-4">
                <!-- Datos personales -->
                <div class="row">
        
                    <input type="hidden" name="ciclo_id" value="{{ $ciclo_id }}">
                    <input type="hidden" name="estudiante_id" value="{{ $estudiante_id }}">

                    <div class="col-12 mt-3">
                        <p class="mb-0 fw-bolder text-primary">
                            INFORMACIÓN DE MATRÍCULA
                        </p>
                        <hr class="mt-0 border-primary opacity-25">
                    </div>
        
                    <div class="col-md-4 mb-3">
                        <label for="area_id" class="form-label">Área</label>
                        <select name="area_id" id="area_id" class="form-select @error('area_id') is-invalid @enderror" required>
                            <option value="">Seleccionar Área</option>
                            @foreach ($areas as $item)
                            <option value="{{ $item->id }}" {{ $item->id == old('area_id', $matricula->area_id) ? 'selected' : '' }}>
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
                            <option value="{{ $sede->id }}" {{ $sede->id == old('sede_id', $matricula->sede_id) ? 'selected' : '' }}>
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
                            <option value="">Seleccione</option>
                            {{-- @foreach ($aulaCicloDisponibles as $aulaCiclo)
                            <option value="{{ $aulaCiclo->id }}"
                                {{ $aulaCiclo->id == old('aula_ciclo_id', $matricula->aulas->first()?->id) ? 'selected' : '' }}
                                {{ $aulaCiclo->full ? 'disabled' : '' }}
                                title="{{ $aulaCiclo->full ? 'Este aula ha alcanzado su aforo máximo.' : '' }}"
                                >
                                {{ $aulaCiclo->aula->descripcion }}
                            </option>
                            @endforeach --}}
                        </select>
                        @error('aula_ciclo_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="col-md-4 mb-3">
                        <label for="modalidad_estudio" class="form-label">Modalidad de estudio</label>
                        <select name="modalidad_estudio" id="modalidad_estudio"
                            class="form-select @error('modalidad_estudio') is-invalid @enderror" required>
                            @foreach ($modalidades_estudio as $modalidad)
                            <option value="{{ $modalidad }}" {{ $modalidad == old('modalidad_estudio', $matricula->modalidad_estudio) ? 'selected' : '' }}>
                                {{ $modalidad }}
                            </option>
                            @endforeach
                        </select>
                        @error('modalidad_estudio')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="condicion_academica" class="form-label">Condición académica</label>
                        <select name="condicion_academica" id="condicion_academica"
                            class="form-select @error('condicion_academica') is-invalid @enderror" required>
                            @foreach ($condiciones_acadedmicas as $condicion)
                            <option value="{{ $condicion }}" {{ $condicion == old('condicion_academica', $matricula->condicion_academica) ? 'selected' : '' }}>
                                {{ $condicion }}
                            </option>
                            @endforeach
                        </select>
                        @error('condicion_academica')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="cantidad_matricula" class="form-label">Veces matriculados en Cepre</label>
                        <input name="cantidad_matricula" type="text" id="cantidad_matricula"
                            class="form-control @error('cantidad_matricula') is-invalid @enderror"
                            value="{{ old('cantidad_matricula', $matricula->cantidad_matricula) }}" autocomplete="off" />
                        @error('cantidad_matricula')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
        
                <div class="col-12 mt-3">
                    <p class="mb-0 fw-bolder text-primary">
                        INFORMACIÓN DE PAGO
                        <small class="text-dark fw-normal">(Primer pago)</small>
                    </p>
                    <hr class="mt-0 border-primary opacity-25">
                </div>
        
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="forma_de_pago_id" class="form-label">Modalidad de pago</label>
                        <select name="forma_de_pago_id" id="forma_de_pago_id" class="form-select @error('forma_de_pago_id') is-invalid @enderror" required>
                            <!-- Opción de 'null' o vacía -->
                            <option value="" {{ is_null(old('forma_de_pago_id', $matricula->pagos->first()?->forma_de_pago_id)) ? 'selected' : '' }}>
                                -- Seleccionar modalidad de pago --
                            </option>                    
                            @foreach ($formasDePago as $modalidad)
                            <option value="{{ $modalidad->id }}" {{ $modalidad->id == old('forma_de_pago_id', $matricula->pagos->first()?->forma_de_pago_id) ? 'selected' : '' }}>
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
                            <option value="{{ $banco->id }}" {{ $banco->id == old('banco_id', $matricula->pagos->first()?->banco_id) ? 'selected' : '' }}>
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
                        <input name="fecha_pago" type="date" id="fecha_pago" 
                            class="form-control @error('fecha_pago') is-invalid @enderror" 
                            value="{{ old('fecha_pago', optional($matricula->pagos->first())->fecha_pago ? \Carbon\Carbon::parse(optional($matricula->pagos->first())->fecha_pago)->format('Y-m-d') : '') }}"
                             />
                        @error('fecha_pago')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
        
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="cod_operacion" class="form-label">Código de operación</label>
                        <input name="cod_operacion" type="text" id="cod_operacion" 
                            class="form-control @error('cod_operacion') is-invalid @enderror" 
                            value="{{ old('descripcion_pago', $matricula->pagos->first()?->cod_operacion) }}" autocomplete="off" />
                        @error('cod_operacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <div class="col-md-4 mb-3">
                        <label for="descripcion_pago" class="form-label">Descripción del pago</label>
                        <input name="descripcion_pago" type="text" id="descripcion_pago" class="form-control @error('descripcion_pago') is-invalid @enderror" 
                            value="{{ old('descripcion_pago', $matricula->pagos->first()?->descripcion_pago) }}" autocomplete="off" required/>
                        @error('descripcion_pago')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <div class="col-md-4 mb-3">
                        <label for="n_transaccion" class="form-label">Número de transacción</label>
                        <input name="n_transaccion" type="text" id="n_transaccion" 
                            class="form-control @error('n_transaccion') is-invalid @enderror"
                            value="{{ old('n_transaccion', $matricula->pagos->first()?->n_transaccion) }}" autocomplete="off" />
                        @error('n_transaccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
        
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="monto" class="form-label">Monto</label>
                        <input name="monto" type="number" id="monto" class="form-control @error('monto') is-invalid @enderror" 
                            value="{{ old('monto', $matricula->pagos->first()?->monto) }}" autocomplete="off" step="0.01" required/>
                        @error('monto')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="comision" class="form-label">Comisión</label>
                        <input name="comision" type="number" id="comision" class="form-control @error('comision') is-invalid @enderror" 
                            value="{{ old('comision', $matricula->pagos->first()?->comision) }}" autocomplete="off" step="0.01" required/>
                        @error('comision')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <div class="col-md-4 mb-3">
                        <label for="monto_neto" class="form-label">Monto neto</label>
                        <input name="monto_neto" type="number" id="monto_neto" class="form-control @error('monto_neto') is-invalid @enderror" 
                            value="{{ old('monto_neto', $matricula->pagos->first()?->monto_neto) }}" autocomplete="off" step="0.01" required/>
                        @error('monto_neto')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="condicion_pago" class="form-label">Condición de pago</label>
                        <select name="condicion_pago" id="condicion_pago" class="form-select @error('condicion_pago') is-invalid @enderror" required>
                            <option value="" {{ old('condicion_pago', $matricula->pagos->first()?->condicion_pago)==null ? 'selected' : '' }}>Seleccione</option>
                            <option value="Cancelado" {{ old('condicion_pago', $matricula->pagos->first()?->condicion_pago)=='Cancelado' ? 'selected' : '' }}>
                                Cancelado
                            </option>
                            <option value="Parcial" {{ old('condicion_pago', $matricula->pagos->first()?->condicion_pago)=='Parcial' ? 'selected' : '' }}>
                                Parcial
                            </option>
                        </select>
                        @error('condicion_pago')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
        
                <div class="row">
                    <div class="col text-end">
                        <a href="{{ route('ciclos.show', $ciclo->id) }}" class="btn btn-outline-primary me-3">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary px-8">
                            <i class="ti ti-device-floppy"></i>
                            Actualizar
                        </button>
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
    const areaSelect = document.getElementById('area_id');
    
    const carreraSelect = document.getElementById('carrera_id');
    
    const selectedCarreraId = {{ $matricula->carrera_id ?? 'null' }};

    // Obtener el elemento del select de Carrera
    const aulaCicloSelect = document.getElementById('aula_ciclo_id');
    const aulasCiclosDisponibles = @json($aulaCicloDisponibles);
    let aulasCiclo = @json($matricula->aulas ?? []);
    
    let currentAulaCicloId = null;
    if (aulasCiclo.length > 0 ){
        currentAulaCicloId = aulasCiclo[0].id
    }

    function loadCarreras(areaId) {
        carreraSelect.innerHTML = '<option value="">Seleccionar Carrera</option>';
        aulaCicloSelect.innerHTML = '';

        if (areaId) {
            fetch(`/carreras/${areaId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(carrera => {
                            const option = document.createElement('option');
                            option.value = carrera.id;
                            option.textContent = carrera.descripcion;

                            if (carrera.id == selectedCarreraId) {
                                option.selected = true;
                            }
                            carreraSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error al cargar las carreras:', error);
                });
            
            // Filtrar aulas por areas
            const aulaCicloPorArea = aulasCiclosDisponibles.filter(aulaCiclo => aulaCiclo.area_id == areaId);
            aulaCicloPorArea.forEach(aulaCiclo => {
                const option = document.createElement('option');
                option.value = aulaCiclo.id;
                option.textContent = aulaCiclo.aula.descripcion;
                option.disabled = aulaCiclo.full;
                option.selected = aulaCiclo.id == currentAulaCicloId;
                option.title = aulaCiclo.full ? 'Este aula ha alcanzado su aforo máximo.' : '';
                aulaCicloSelect.appendChild(option);
            });
        }
    }

    areaSelect.addEventListener('change', function() {
        const areaId = this.value;
        loadCarreras(areaId);
    });

    document.addEventListener('DOMContentLoaded', function() {
        const areaId = areaSelect.value;
        if (areaId) {
            loadCarreras(areaId);
        }
    });
</script>

<script>
    // Obtener los elementos por ID
    const montoInput = document.getElementById('monto');
    const comisionInput = document.getElementById('comision');
    const montoNetoInput = document.getElementById('monto_neto');

    // Función para actualizar el monto neto
    function actualizarMontoNeto() {
        const monto = parseFloat(montoInput.value) || 0;  // Si el valor no es un número, usamos 0
        const comision = parseFloat(comisionInput.value) || 0;  // Si el valor no es un número, usamos 0
        montoNetoInput.value = (monto + comision).toFixed(2);  // Sumar monto + comision y limitar a 2 decimales
    }

    // Escuchar los cambios en los campos de monto y comision
    montoInput.addEventListener('input', actualizarMontoNeto);
    comisionInput.addEventListener('input', actualizarMontoNeto);

    // Ejecutar la actualización inicial para asegurarnos que el campo de monto neto esté al día
    actualizarMontoNeto();
</script>

@endsection