@extends('intranet.layouts.app')

@section('css')

<style>
    input[readonly] {
        background-color: #f5f5f5; /* Gris claro */
        border: 1px solid #ccc; /* Borde gris claro */
        color: #6c757d; /* Color gris oscuro */
        pointer-events: none; /* Desactiva la interacción del usuario */
        user-select: none;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

{{-- Breadcrumb|start --}}
<div class="row">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Datos personales del estudiante</h4>
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

        <form action="{{ route('matricula.store_estudiante') }}" method="POST" class="mx-auto p-8 px-10 shadow-md">
            @csrf
            <div class="row g-4">
                <div class="row">

                    <input type="hidden" name="ciclo_id" value="{{ $ciclo_id }}">
                    <input type="hidden" name="estudiante_id" value="{{ $estudiante->id ?? '' }}">

                    <div class="col-12 mt-3">
                        <p class="mb-0 fw-bolder text-primary">
                            INFORMACIÓN BÁSICA
                        </p>
                        <hr class="mt-0">
                    </div>

                    <!-- Tipo de documento -->
                    <div class="col-md-4 mb-3">
                        <label for="tipo_documento_id" class="form-label">Tipo de documento</label>
                        <select name="tipo_documento_id" id="tipo_documento_id"
                            class="form-select @error('tipo_documento_id') is-invalid @enderror">
                            @foreach ($tipos_documentos as $item)
                                <option value="{{ $item->id }}" {{ old('tipo_documento_id', $estudiante->tipo_documento_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_documento_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Número de documento -->
                    <div class="col-md-4 mb-3">
                        <label for="nro_documento" class="form-label">Número de documento</label>
                        <input type="text" name="nro_documento" id="nro_documento"
                            class="form-control @error('nro_documento') is-invalid @enderror"
                            value="{{ $dni }}" autocomplete="off" readonly>
                        @error('nro_documento')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nombres -->
                    <div class="col-md-4 mb-3">
                        <label for="nombres" class="form-label">Nombres</label>
                        <input type="text" name="nombres" id="nombres"
                            class="form-control @error('nombres') is-invalid @enderror"
                            value="{{ old('nombres', $estudiante->nombres ?? '') }}" autocomplete="off">
                        @error('nombres')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Apellido paterno -->
                    <div class="col-md-4 mb-3">
                        <label for="apellido_paterno" class="form-label">Apellido paterno</label>
                        <input type="text" name="apellido_paterno" id="apellido_paterno"
                            class="form-control @error('apellido_paterno') is-invalid @enderror"
                            value="{{ old('apellido_paterno', $estudiante->apellido_paterno ?? '') }}"
                            autocomplete="off">
                        @error('apellido_paterno')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Apellido materno -->
                    <div class="col-md-4 mb-3">
                        <label for="apellido_materno" class="form-label">Apellido materno</label>
                        <input type="text" name="apellido_materno" id="apellido_materno"
                            class="form-control @error('apellido_materno') is-invalid @enderror"
                            value="{{ old('apellido_materno', $estudiante->apellido_materno ?? '') }}"
                            autocomplete="off">
                        @error('apellido_materno')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Género -->
                    <div class="col-md-4 mb-3">
                        <label for="genero_id" class="form-label">Género</label>
                        <select name="genero_id" id="genero_id"
                            class="form-select @error('genero_id') is-invalid @enderror">
                            @foreach ($generos as $item)
                                <option value="{{ $item->id }}" {{ old('genero_id', $estudiante->genero_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        @error('genero_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mt-3">
                        <p class="mb-0 fw-bolder text-primary">
                            INFORMACIÓN DE NACIMIENTO
                        </p>
                        <hr class="mt-0">
                    </div>

                    <!-- País de nacimiento -->
                    <div class="col-md-4 mb-3">
                        <label for="pais_nacimiento" class="form-label">País de nacimiento</label>
                        <select name="pais_nacimiento" id="pais_nacimiento"
                            class="form-select @error('pais_nacimiento') is-invalid @enderror">
                            @foreach ($paises as $pais)
                                <option value="{{ $pais['code'] }}" {{ old('pais_nacimiento', $estudiante->pais_nacimiento ?? '') == $pais['code'] ? 'selected' : '' }}>
                                    {{ $pais['es_name'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('pais_nacimiento')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nacionalidad -->
                    <div class="col-md-4 mb-3">
                        <label for="nacionalidad" class="form-label">Nacionalidad</label>
                        <select name="nacionalidad" id="nacionalidad"
                            class="form-select @error('nacionalidad') is-invalid @enderror">
                            @foreach ($paises as $pais)
                                <option value="{{ $pais['nationality'] }}" {{ old('nacionalidad', $estudiante->nacionalidad ?? '') == $pais['nationality'] ? 'selected' : '' }}>
                                    {{ $pais['nationality'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('nacionalidad')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Ubigeo de nacimiento -->
                    <div class="col-md-4 mb-3">
                        <label for="nacimiento_ubigeodepartamento_id" class="form-label">Departamento de nacimiento</label>
                        <select name="nacimiento_ubigeodepartamento_id" id="nacimiento_ubigeodepartamento_id"
                                class="form-select @error('nacimiento_ubigeodepartamento_id') is-invalid @enderror">
                                <option value="">Seleccione un departamento</option>
                        </select>
                        @error('nacimiento_ubigeodepartamento_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="nacimiento_ubigeoprovincia_id" class="form-label">Provincia de nacimiento</label>
                        <select name="nacimiento_ubigeoprovincia_id" id="nacimiento_ubigeoprovincia_id"
                                class="form-select @error('nacimiento_ubigeoprovincia_id') is-invalid @enderror">
                            <option value="">Seleccione una provincia</option>
                        </select>
                        @error('nacimiento_ubigeoprovincia_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="nacimiento_ubigeodistrito_id" class="form-label">Distrito de nacimiento</label>
                        <select name="nacimiento_ubigeodistrito_id" id="nacimiento_ubigeodistrito_id"
                                class="form-select @error('nacimiento_ubigeodistrito_id') is-invalid @enderror">
                            <option value="">Seleccione un distrito</option>
                        </select>
                        @error('nacimiento_ubigeodistrito_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Fecha de nacimiento -->
                    <div class="col-md-4 mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                            class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                            value="{{ old('fecha_nacimiento', $estudiante->fecha_nacimiento ?? '2000-01-01') }}" autocomplete="off">
                        @error('fecha_nacimiento')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Estado civil -->
                    <div class="col-md-4 mb-3">
                        <label for="estado_civil_id" class="form-label">Estado civil</label>
                        <select name="estado_civil_id" id="estado_civil_id"
                            class="form-select @error('estado_civil_id') is-invalid @enderror">
                            @foreach ($estados_civiles as $item)
                                <option value="{{ $item->id }}" {{ old('estado_civil_id', $estudiante->estado_civil_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        @error('estado_civil_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Identidad étnica -->
                    <div class="col-md-4 mb-3">
                        <label for="identidad_etnica_id" class="form-label">Identidad étnica</label>
                        <select name="identidad_etnica_id" id="identidad_etnica_id"
                            class="form-select @error('identidad_etnica_id') is-invalid @enderror">
                            @foreach ($identidades_etnicas as $item)
                                <option value="{{ $item->id }}" {{ old('identidad_etnica_id', $estudiante->identidad_etnica_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        @error('identidad_etnica_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="col-12 mt-3">
                        <p class="mb-0 fw-bolder text-primary">
                            INFORMACIÓN DE CONTACTO
                        </p>
                        <hr class="mt-0">
                    </div>

                    <!-- Ubigeo de dirección -->
                    <div class="col-md-4 mb-3">
                        <label for="direccion_ubigeodepartamento_id" class="form-label">Departamento de Dirección</label>
                        <select name="direccion_ubigeodepartamento_id" id="direccion_ubigeodepartamento_id"
                                class="form-select @error('direccion_ubigeodepartamento_id') is-invalid @enderror">
                                <option value="">Seleccione un departamento</option>
                        </select>
                        @error('direccion_ubigeodepartamento_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="direccion_ubigeoprovincia_id" class="form-label">Provincia de Dirección</label>
                        <select name="direccion_ubigeoprovincia_id" id="direccion_ubigeoprovincia_id"
                                class="form-select @error('direccion_ubigeoprovincia_id') is-invalid @enderror">
                                <option value="">Seleccione una provincia</option>
                        </select>
                        @error('direccion_ubigeoprovincia_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="direccion_ubigeodistrito_id" class="form-label">Distrito de Dirección</label>
                        <select name="direccion_ubigeodistrito_id" id="direccion_ubigeodistrito_id"
                                class="form-select @error('direccion_ubigeodistrito_id') is-invalid @enderror">
                                <option value="">Seleccione un distrito</option>
                        </select>
                        @error('direccion_ubigeodistrito_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Dirección -->
                    <div class="col-md-4 mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" name="direccion" id="direccion"
                            class="form-control @error('direccion') is-invalid @enderror"
                            value="{{ old('direccion', $estudiante->direccion ?? '') }}" autocomplete="off">
                        @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Teléfono personal -->
                    <div class="col-md-4 mb-3">
                        <label for="telefono_personal" class="form-label">Teléfono personal</label>
                        <input type="text" name="telefono_personal" id="telefono_personal"
                            class="form-control @error('telefono_personal') is-invalid @enderror"
                            value="{{ old('telefono_personal', $estudiante->telefono_personal ?? '') }}" autocomplete="off" maxlength="9"
                            placeholder="9..."
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        @error('telefono_personal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- WhatsApp -->
                    <div class="col-md-4 mb-3">
                        <label for="whatsapp" class="form-label">WhatsApp</label>
                        <input type="text" name="whatsapp" id="whatsapp"
                            class="form-control @error('whatsapp') is-invalid @enderror"
                            value="{{ old('whatsapp', $estudiante->whatsapp ?? '') }}" autocomplete="off" maxlength="9"
                            placeholder="9..."
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        @error('whatsapp')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Correo personal -->
                    <div class="col-md-4 mb-3">
                        <label for="correo_personal" class="form-label">Correo personal</label>
                        <input type="email" name="correo_personal" id="correo_personal"
                            class="form-control @error('correo_personal') is-invalid @enderror"
                            value="{{ old('correo_personal', $estudiante->correo_personal ?? '') }}" autocomplete="off">
                        @error('correo_personal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Correo institucional -->
                    <div class="col-md-4 mb-3">
                        <label for="correo_institucional" class="form-label">Correo institucional</label>
                        <input type="email" name="correo_institucional" id="correo_institucional"
                            class="form-control @error('correo_institucional') is-invalid @enderror"
                            value="{{ old('correo_institucional', $estudiante->correo_institucional ?? '') }}" autocomplete="off">
                        @error('correo_institucional')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Teléfono del apoderado -->
                    <div class="col-md-4 mb-3">
                        <label for="telefono_apoderado" class="form-label">Teléfono del apoderado</label>
                        <input type="text" name="telefono_apoderado" id="telefono_apoderado"
                            class="form-control @error('telefono_apoderado') is-invalid @enderror"
                            value="{{ old('telefono_apoderado', $estudiante->telefono_apoderado ?? '') }}" autocomplete="off" maxlength="9">
                        @error('telefono_apoderado')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Correo del apoderado -->
                    <div class="col-md-4 mb-3">
                        <label for="correo_apoderado" class="form-label">Correo del apoderado</label>
                        <input type="email" name="correo_apoderado" id="correo_apoderado"
                            class="form-control @error('correo_apoderado') is-invalid @enderror"
                            value="{{ old('correo_apoderado', $estudiante->correo_apoderado ?? '') }}" autocomplete="off">
                        @error('correo_apoderado')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Parentesco -->
                    <div class="col-md-4 mb-3">
                        <label for="parentesco_id" class="form-label">Parentesco con el apoderado</label>
                        <select name="parentesco_id" id="parentesco_id" class="form-select @error('parentesco_id') is-invalid @enderror">
                            @foreach ($parentescos as $item)
                                <option value="{{ $item->id }}" {{ old('parentesco_id', $estudiante->parentesco_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        @error('parentesco_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                    <div class="col-12 mt-3">
                        <p class="mb-0 fw-bolder text-primary">
                            INFORMACIÓN ADICIONAL
                        </p>
                        <hr class="mt-0">
                    </div>
                    
                    <!-- Colegios Departamento -->
                    <div class="col-md-4 mb-3">
                        <label for="colegio_ubigeodepartamento_id" class="form-label">Departamento de Colegio</label>
                        <select name="colegio_ubigeodepartamento_id" id="colegio_ubigeodepartamento_id"
                                class="form-select @error('colegio_ubigeodepartamento_id') is-invalid @enderror">
                                <option value="">Seleccione un departamento</option>
                        </select>
                        @error('colegio_ubigeodepartamento_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Colegios Provincia -->
                    <div class="col-md-4 mb-3">
                        <label for="colegio_ubigeoprovincia_id" class="form-label">Provincia de Colegio</label>
                        <select name="colegio_ubigeoprovincia_id" id="colegio_ubigeoprovincia_id"
                                class="form-select @error('colegio_ubigeoprovincia_id') is-invalid @enderror">
                                <option value="">Seleccione una provincia</option>
                        </select>
                        @error('colegio_ubigeoprovincia_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Colegios Distrito -->
                    <div class="col-md-4 mb-3">
                        <label for="colegio_ubigeodistrito_id" class="form-label">Distrito de Colegio</label>
                        <select name="colegio_ubigeodistrito_id" id="colegio_ubigeodistrito_id"
                                class="form-select @error('colegio_ubigeodistrito_id') is-invalid @enderror">
                                <option value="">Seleccione un distrito</option>
                        </select>
                        @error('colegio_ubigeodistrito_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Colegio -->
                    <div class="col-md-4 mb-3">
                        <label for="colegio_id" class="form-label">Colegio</label>
                        <select name="colegio_id" id="colegio_id"
                                class="form-select @error('colegio_id') is-invalid @enderror">
                            <option value="">Seleccione un colegio</option>
                        </select>
                        @error('colegio_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Año de culminación -->
                    <div class="col-md-4 mb-3">
                        <label for="year_culminacion" class="form-label">Año de culminación de Secundaria</label>
                        <input type="text" name="year_culminacion" id="year_culminacion"
                            class="form-control @error('year_culminacion') is-invalid @enderror"
                            value="{{ old('year_culminacion', $estudiante->year_culminacion ?? '') }}" autocomplete="off" maxlength="4"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            placeholder="20.."/>
                        @error('year_culminacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="tiene_discapacidad" class="form-label">¿Tiene Discapacidad?</label>
                        <select name="tiene_discapacidad" id="tiene_discapacidad" class="form-select">
                            <option value="0">No</option>
                            <option value="1">Sí</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4 mb-3" id="discapacidades-section" style="display:none;">
                        <label for="discapacidades" class="form-label">Seleccione las discapacidades</label>
                        <select name="discapacidades[]" id="discapacidades" class="form-select border" multiple>
                            @foreach($discapacidades as $discapacidad)
                                <option value="{{ $discapacidad->id }}">{{ $discapacidad->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary px-8">Continuar</button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#discapacidades').select2({
            placeholder: "Seleccione discacidades",
            allowClear: true,
            width: '100%',
        });

        $('#tiene_discapacidad').change(function() {
            if ($(this).val() == '1') {
                $('#discapacidades-section').show();
            } else {
                $('#discapacidades-section').hide();
                $('#discapacidades').val([]).trigger('change');
            }
        });
    });
</script>

<script>
    // Dirección de nacimiento
    document.addEventListener('DOMContentLoaded', function() {
        // Función para obtener departamentos inicialmente
        function getDepartamentos() {
            const departamentoSelect = document.getElementById('nacimiento_ubigeodepartamento_id');
            departamentoSelect.innerHTML = '<option value="">Seleccione un departamento</option>';
            fetch(`/api/common/ubigeos`)
                .then(response => response.json())
                .then(data => {
                    data.data.forEach(departamento => {
                        const option = document.createElement('option');
                        option.value = departamento.id;
                        option.textContent = departamento.descripcion;
                        departamentoSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar departamentos:', error));
        }

        // Función para obtener provincias según el departamento
        function getProvincias(departamentoId) {
            const provinciaSelect = document.getElementById('nacimiento_ubigeoprovincia_id');
            provinciaSelect.innerHTML = '<option value="">Seleccione una provincia</option>';

            fetch(`/api/common/ubigeos?departamento=${departamentoId}`)
                .then(response => response.json())
                .then(data => {
                    data.data.forEach(provincia => {
                        const option = document.createElement('option');
                        option.value = provincia.id;
                        option.textContent = provincia.descripcion;
                        provinciaSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar provincias:', error));
        }

        // Función para obtener distritos según la provincia
        function getDistritos(provinciaId) {
            const distritoSelect = document.getElementById('nacimiento_ubigeodistrito_id');
            distritoSelect.innerHTML = '<option value="">Seleccione un distrito</option>'; // Limpiar distritos

            fetch(`/api/common/ubigeos?provincia=${provinciaId}`)
                .then(response => response.json())
                .then(data => {
                    data.data.forEach(distrito => {
                        const option = document.createElement('option');
                        option.value = distrito.id;
                        option.textContent = distrito.descripcion;
                        distritoSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar distritos:', error));
        }

        getDepartamentos();

        // Event listener para el cambio en el select del departamento
        const departamentoSelect = document.getElementById('nacimiento_ubigeodepartamento_id');
        departamentoSelect.addEventListener('change', function() {
            const departamentoId = this.value;
            if (departamentoId) {
                getProvincias(departamentoId); // Cargar provincias
                document.getElementById('nacimiento_ubigeodistrito_id').innerHTML = '<option value="">Seleccione un distrito</option>';
            }
        });

        // Event listener para el cambio en el select de la provincia
        const provinciaSelect = document.getElementById('nacimiento_ubigeoprovincia_id');
        provinciaSelect.addEventListener('change', function() {
            const provinciaId = this.value;
            if (provinciaId) {
                getDistritos(provinciaId); // Cargar distritos
            }
        });
    });

    // Dirección actual
    document.addEventListener('DOMContentLoaded', function() {
        // Función para obtener departamentos de dirección
        function getDepartamentosDireccion() {
            const departamentoSelect = document.getElementById('direccion_ubigeodepartamento_id');
            departamentoSelect.innerHTML = '<option value="">Seleccione un departamento</option>';

            fetch(`/api/common/ubigeos`)
                .then(response => response.json())
                .then(data => {
                    data.data.forEach(departamento => {
                        const option = document.createElement('option');
                        option.value = departamento.id;
                        option.textContent = departamento.descripcion;
                        departamentoSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar departamentos de dirección:', error));
        }

        // Función para obtener provincias de dirección según el departamento
        function getProvinciasDireccion(departamentoId) {
            const provinciaSelect = document.getElementById('direccion_ubigeoprovincia_id');
            provinciaSelect.innerHTML = '<option value="">Seleccione una provincia</option>';

            fetch(`/api/common/ubigeos?departamento=${departamentoId}`)
                .then(response => response.json())
                .then(data => {
                    data.data.forEach(provincia => {
                        const option = document.createElement('option');
                        option.value = provincia.id;
                        option.textContent = provincia.descripcion;
                        provinciaSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar provincias de dirección:', error));
        }

        // Función para obtener distritos de dirección según la provincia
        function getDistritosDireccion(provinciaId) {
            const distritoSelect = document.getElementById('direccion_ubigeodistrito_id');
            distritoSelect.innerHTML = '<option value="">Seleccione un distrito</option>'; // Limpiar distritos

            fetch(`/api/common/ubigeos?provincia=${provinciaId}`)
                .then(response => response.json())
                .then(data => {
                    data.data.forEach(distrito => {
                        const option = document.createElement('option');
                        option.value = distrito.id;
                        option.textContent = distrito.descripcion;
                        distritoSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar distritos de dirección:', error));
        }

        // Cargar los departamentos de dirección al inicio
        getDepartamentosDireccion();

        // Event listener para el cambio en el select del departamento de dirección
        const departamentoSelect = document.getElementById('direccion_ubigeodepartamento_id');
        departamentoSelect.addEventListener('change', function() {
            const departamentoId = this.value;
            if (departamentoId) {
                getProvinciasDireccion(departamentoId); // Cargar provincias
                document.getElementById('direccion_ubigeodistrito_id').innerHTML = '<option value="">Seleccione un distrito</option>';
            }
        });

        // Event listener para el cambio en el select de la provincia de dirección
        const provinciaSelect = document.getElementById('direccion_ubigeoprovincia_id');
        provinciaSelect.addEventListener('change', function() {
            const provinciaId = this.value;
            if (provinciaId) {
                getDistritosDireccion(provinciaId); // Cargar distritos
            }
        });
    });

    // Filtrar colegios
    document.addEventListener('DOMContentLoaded', function() {
        // Función para obtener departamentos de colegios
        function getDepartamentosColegio() {
            const departamentoSelect = document.getElementById('colegio_ubigeodepartamento_id');
            departamentoSelect.innerHTML = '<option value="">Seleccione un departamento</option>';

            fetch(`/api/common/ubigeos`)
                .then(response => response.json())
                .then(data => {
                    data.data.forEach(departamento => {
                        const option = document.createElement('option');
                        option.value = departamento.id;
                        option.textContent = departamento.descripcion;
                        departamentoSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar departamentos de colegio:', error));
        }

        // Función para obtener provincias de colegios según el departamento
        function getProvinciasColegio(departamentoId) {
            const provinciaSelect = document.getElementById('colegio_ubigeoprovincia_id');
            provinciaSelect.innerHTML = '<option value="">Seleccione una provincia</option>';

            fetch(`/api/common/ubigeos?departamento=${departamentoId}`)
                .then(response => response.json())
                .then(data => {
                    data.data.forEach(provincia => {
                        const option = document.createElement('option');
                        option.value = provincia.id;
                        option.textContent = provincia.descripcion;
                        provinciaSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar provincias de colegio:', error));
        }

        // Función para obtener distritos de colegios según la provincia
        function getDistritosColegio(provinciaId) {
            const distritoSelect = document.getElementById('colegio_ubigeodistrito_id');
            distritoSelect.innerHTML = '<option value="">Seleccione un distrito</option>'; // Limpiar distritos

            fetch(`/api/common/ubigeos?provincia=${provinciaId}`)
                .then(response => response.json())
                .then(data => {
                    data.data.forEach(distrito => {
                        const option = document.createElement('option');
                        option.value = distrito.id;
                        option.textContent = distrito.descripcion;
                        distritoSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar distritos de colegio:', error));
        }


        // Función para obtener colegios según la distrito
        function getColegios(distritoId) {
            const colegioSelect = document.getElementById('colegio_id');
            colegioSelect.innerHTML = '<option value="">Seleccione colegio</option>'; // Limpiar colegios

            fetch(`/api/common/colegios?ubigeo=${distritoId}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    
                    data.data.forEach(colegio => {
                        const option = document.createElement('option');
                        option.value = colegio.id;
                        option.textContent = colegio.cen_edu;
                        colegioSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar colegios:', error));
        }

        // Cargar los departamentos de colegios al inicio
        getDepartamentosColegio();

        // Event listener para el cambio en el select del departamento de colegio
        const departamentoSelect = document.getElementById('colegio_ubigeodepartamento_id');
        departamentoSelect.addEventListener('change', function() {
            const departamentoId = this.value;
            if (departamentoId) {
                getProvinciasColegio(departamentoId); // Cargar provincias
                document.getElementById('colegio_ubigeodistrito_id').innerHTML = '<option value="">Seleccione un distrito</option>';
                document.getElementById('colegio_id').innerHTML = '<option value="">Seleccione un colegio</option>';
                
            }
        });

        // Event listener para el cambio en el select de la provincia de colegio
        const provinciaSelect = document.getElementById('colegio_ubigeoprovincia_id');
        provinciaSelect.addEventListener('change', function() {
            const provinciaId = this.value;
            if (provinciaId) {
                getDistritosColegio(provinciaId); // Cargar distritos
                document.getElementById('colegio_id').innerHTML = '<option value="">Seleccione un colegio</option>';
            }
        });

        // Event listener para el cambio en el select de disitrito de colegio
        const distritoSelect = document.getElementById('colegio_ubigeodistrito_id');
        distritoSelect.addEventListener('change', function() {
            const distritoId = this.value;
            if (distritoId) {
                getColegios(distritoId);
            }
        });
    });

</script>

@endsection