@extends('intranet.layouts.app')

@section('content')

{{-- Breadcrumb|start --}}
<div class="row">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Datos personales</h4>
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
                    <input type="hidden" name="id" value="{{ $estudiante->id ?? '' }}">

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
                            value="{{ old('nro_documento', $estudiante->nro_documento ?? '') }}" autocomplete="off">
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


                    <!-- Teléfono personal -->
                    <div class="col-md-4 mb-3">
                        <label for="telefono_personal" class="form-label">Teléfono personal</label>
                        <input type="text" name="telefono_personal" id="telefono_personal"
                            class="form-control @error('telefono_personal') is-invalid @enderror"
                            value="{{ old('telefono_personal', $estudiante->telefono_personal ?? '') }}" autocomplete="off" maxlength="9">
                        @error('telefono_personal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- WhatsApp -->
                    <div class="col-md-4 mb-3">
                        <label for="whatsapp" class="form-label">WhatsApp</label>
                        <input type="text" name="whatsapp" id="whatsapp"
                            class="form-control @error('whatsapp') is-invalid @enderror"
                            value="{{ old('whatsapp', $estudiante->whatsapp ?? '') }}" autocomplete="off" maxlength="9">
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

                    <!-- Ubigeo de nacimiento -->
                    {{-- <div class="col-md-4 mb-3">
                        <label for="nacimiento_ubigeodepartamento_id" class="form-label">Departamento de nacimiento</label>
                        <select name="nacimiento_ubigeodepartamento_id" id="nacimiento_ubigeodepartamento_id"
                                class="form-select @error('nacimiento_ubigeodepartamento_id') is-invalid @enderror">
                            @foreach ($ubigeo_departamentos as $item)
                                <option value="{{ $item->id }}" {{ old('nacimiento_ubigeodepartamento_id', $estudiante->nacimiento_ubigeodepartamento_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('nacimiento_ubigeodepartamento_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="nacimiento_ubigeoprovincia_id" class="form-label">Provincia de nacimiento</label>
                        <select name="nacimiento_ubigeoprovincia_id" id="nacimiento_ubigeoprovincia_id"
                                class="form-select @error('nacimiento_ubigeoprovincia_id') is-invalid @enderror">
                            @foreach ($ubigeo_provincias as $item)
                                <option value="{{ $item->id }}" {{ old('nacimiento_ubigeoprovincia_id', $estudiante->nacimiento_ubigeoprovincia_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('nacimiento_ubigeoprovincia_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="nacimiento_ubigeodistrito_id" class="form-label">Distrito de nacimiento</label>
                        <select name="nacimiento_ubigeodistrito_id" id="nacimiento_ubigeodistrito_id"
                                class="form-select @error('nacimiento_ubigeodistrito_id') is-invalid @enderror">
                            @foreach ($ubigeo_distritos as $item)
                                <option value="{{ $item->id }}" {{ old('nacimiento_ubigeodistrito_id', $estudiante->nacimiento_ubigeodistrito_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('nacimiento_ubigeodistrito_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <!-- Ubigeo de dirección -->
                    {{-- <div class="col-md-4 mb-3">
                        <label for="direccion_ubigeodepartamento_id" class="form-label">Departamento de dirección</label>
                        <select name="direccion_ubigeodepartamento_id" id="direccion_ubigeodepartamento_id"
                                class="form-select @error('direccion_ubigeodepartamento_id') is-invalid @enderror">
                            @foreach ($ubigeo_departamentos as $item)
                                <option value="{{ $item->id }}" {{ old('direccion_ubigeodepartamento_id', $estudiante->direccion_ubigeodepartamento_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('direccion_ubigeodepartamento_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="direccion_ubigeoprovincia_id" class="form-label">Provincia de dirección</label>
                        <select name="direccion_ubigeoprovincia_id" id="direccion_ubigeoprovincia_id"
                                class="form-select @error('direccion_ubigeoprovincia_id') is-invalid @enderror">
                            @foreach ($ubigeo_provincias as $item)
                                <option value="{{ $item->id }}" {{ old('direccion_ubigeoprovincia_id', $estudiante->direccion_ubigeoprovincia_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('direccion_ubigeoprovincia_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="direccion_ubigeodistrito_id" class="form-label">Distrito de dirección</label>
                        <select name="direccion_ubigeodistrito_id" id="direccion_ubigeodistrito_id"
                                class="form-select @error('direccion_ubigeodistrito_id') is-invalid @enderror">
                            @foreach ($ubigeo_distritos as $item)
                                <option value="{{ $item->id }}" {{ old('direccion_ubigeodistrito_id', $estudiante->direccion_ubigeodistrito_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('direccion_ubigeodistrito_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}

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

                    <!-- Colegio -->
                    {{-- <div class="col-md-4 mb-3">
                        <label for="colegio_id" class="form-label">Colegio</label>
                        <select name="colegio_id" id="colegio_id"
                                class="form-select @error('colegio_id') is-invalid @enderror">
                            @foreach ($colegios as $item)
                                <option value="{{ $item->id }}" {{ old('colegio_id', $estudiante->colegio_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('colegio_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <!-- Año de culminación -->
                    <div class="col-md-4 mb-3">
                        <label for="year_culminacion" class="form-label">Año de culminación de Secundaria</label>
                        <input type="number" name="year_culminacion" id="year_culminacion"
                            class="form-control @error('year_culminacion') is-invalid @enderror"
                            value="{{ old('year_culminacion', $estudiante->year_culminacion ?? '') }}" autocomplete="off">
                        @error('year_culminacion')
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

                    <!-- ¿Tiene discapacidad? -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="tiene_discapacidad" id="tiene_discapacidad" {{ old('tiene_discapacidad', $estudiante->tiene_discapacidad ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="tiene_discapacidad">
                            ¿Tiene discapacidad?
                        </label>
                        @error('tiene_discapacidad')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sección de discapacidades -->
                    <div id="discapacidad-section" class="form-check mb-3"
                        style="display: {{ old('tiene_discapacidad', $estudiante->tiene_discapacidad ?? false) ? 'block' : 'none' }};">
                        <label for="discapacidades" class="form-label">Seleccione las discapacidades</label>
                        <select name="discapacidades[]" id="discapacidades"
                            class="form-select @error('discapacidades') is-invalid @enderror" multiple>
                            @foreach ($discapacidades as $discapacidad)
                                <option value="{{ $discapacidad->id }}" {{ in_array($discapacidad->id, old('discapacidades', [])) ? 'selected' : '' }}>
                                    {{ $discapacidad->descripcion }}
                                </option>
                            @endforeach
                        </select>
                        @error('discapacidades')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <button type="submit" class="btn btn-primary px-8">Continuar</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        const discapacidadCheckbox = document.getElementById('tiene_discapacidad');
        const discapacidadSection = document.getElementById('discapacidad-section');
        const discapacidadSelect = document.getElementById('discapacidades');

        function toggleDiscapacidadField() {
            if (discapacidadCheckbox.checked) {
                discapacidadSection.style.display = 'block';
            } else {
                discapacidadSection.style.display = 'none';
                discapacidadSelect.selectedIndex = -1;
                discapacidadSelect.value = "";
            }
        }

        toggleDiscapacidadField();

        discapacidadCheckbox.addEventListener('change', toggleDiscapacidadField);
    });
</script>


@endsection