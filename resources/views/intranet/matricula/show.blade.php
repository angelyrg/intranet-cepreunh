@extends('intranet.layouts.app')

@section('content')

{{-- TODO: Estandarizar los breadcrumbs --}}
{{-- Breadcrumb|start --}}
<div class="row">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <h4 class="fw-semibold mb-8">Resumen de la matrícula</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('ciclos.index') }}">Ciclos</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('ciclos.show', $matricula->ciclo->id) }}">
                                    {{ $matricula->ciclo->descripcion }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Matrícula</li>
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
        <div class="card shadow rounded-3">
            <div class="card-body">
                <h5 class="text-center">MATRÍCULA</h5>
                <hr class="mt-0 mb-2">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Ciclo:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0 text-uppercase fw-bold">{{ $matricula->ciclo->descripcion }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Duración:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0 text-uppercase">{{ $matricula->ciclo->duracion }} semanas</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Fecha de Inicio:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0 text-uppercase">{{ $matricula->ciclo->fecha_inicio }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Fecha de finalización:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0 text-uppercase">{{ $matricula->ciclo->fecha_fin }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-2">

                <div class="row">

                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Estudiante:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0 text-uppercase">{{ $matricula->estudiante->nombres }}
                                    {{ $matricula->estudiante->apellido_paterno }} {{ $matricula->estudiante->apellido_materno }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Edad:</label>
                            <div class="col-md-5 ">
                                <?php
                                    $fechaNacimiento = $matricula->estudiante->fecha_nacimiento;
                                    $fechaNacimiento = new DateTime($fechaNacimiento);
                                    $fechaActual = new DateTime();
                                    $edad = $fechaActual->diff($fechaNacimiento);
                                ?>
                                <p class="form-control-static mb-0 text-uppercase">{{ $edad->y }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Tipo de documento:</label>
                            <div class="col-md-5">
                                <p class="form-control-static mb-0">{{ $matricula->estudiante->tipo_documento->descripcion }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Nro de documento:</label>
                            <div class="col-md-5">
                                <p class="form-control-static mb-0">{{ $matricula->estudiante->nro_documento }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Genero:</label>
                            <div class="col-md-5">
                                <p class="form-control-static mb-0">{{ $matricula->estudiante->genero->descripcion }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Estado civil:</label>
                            <div class="col-md-5">
                                <p class="form-control-static mb-0">{{ $matricula->estudiante->estado_civil->descripcion }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Fecha de nacimiento:</label>
                            <div class="col-md-5">
                                <p class="form-control-static mb-0">{{ $matricula->estudiante->fecha_nacimiento }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Nacionalidad:</label>
                            <div class="col-md-5">
                                <p class="form-control-static mb-0">{{ $matricula->estudiante->nacionalidad }}</p>
                            </div>
                        </div>
                    </div>


                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Telefono Personal:</label>
                            <div class="col-md-5">
                                <p class="form-control-static mb-0">{{ $matricula->estudiante->telefono_personal }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Whatsapp:</label>
                            <div class="col-md-5">
                                <p class="form-control-static mb-0">{{ $matricula->estudiante->whatsapp }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Correo Personal:</label>
                            <div class="col-md-5">
                                <p class="form-control-static mb-0">{{ $matricula->estudiante->correo_personal }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Correo Institucional:</label>
                            <div class="col-md-5">
                                <p class="form-control-static mb-0">{{ $matricula->estudiante->correo_institucional }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Teléfono del apoderado:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0 text-uppercase">
                                    {{ $matricula->estudiante->apoderado?->telefono_apoderado ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Correo del apoderado:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0 text-uppercase">
                                    {{ $matricula->estudiante->apoderado?->correo_apoderado ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                <hr class="my-2">
                
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Area:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0 text-uppercase">{{ $matricula->area->descripcion }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Sede:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0 text-uppercase">{{ $matricula->sede->descripcion }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Carrera:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0 text-uppercase">{{ $matricula->carrera->descripcion }}</p>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Modalidad de estudio:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0 text-uppercase">{{ $matricula->modalidad_estudio }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Condición académica:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0 text-uppercase">{{ $matricula->condicion_academica }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Veces de matrícula en Cepre:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0 text-uppercase">{{ $matricula->cantidad_matricula }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Aula <small>(Hasta examen de ubicación)</small>:</label>
                            <div class="col-md-5">
                                <p class="form-control-static mb-0 text-uppercase">
                                    {{ $matricula->aulas->first()?->aula->descripcion ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Forma de pago:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0 text-uppercase">
                                    {{ $matricula->pagos->first()?->forma_de_pago->descripcion ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Concepto de pago:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0 text-uppercase">
                                    {{ $matricula->pagos->first()?->descripcion_pago ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Monto:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0">
                                    S/{{ $matricula->pagos->first()?->monto ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Comisión:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0">
                                    S/{{ $matricula->pagos->first()?->comision ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">MONTO NETO:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0">
                                    S/{{ $matricula->pagos->first()?->monto_neto ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <label class="control-label text-end col-md-7">Condición de pago:</label>
                            <div class="col-md-5 ">
                                <p class="form-control-static mb-0 text-uppercase">
                                    {{ $matricula->pagos->first()?->condicion_pago ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    
                    
                </div>

                <div class="row mt-5">
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <div>
                            <a href="{{ route('ciclos.matricula', $matricula->ciclo->id) }}" class="btn btn-primary">
                                <span><i class="ti ti-user-plus"></i></span>
                                <span>Nuevo matrícula</span>
                            </a>
                        </div>
                        <div>
                            <a href="{{ route('matricula.imprimir', $matricula->id) }}" class="btn btn-primary" target="_blank">
                                <span><i class="ti ti-printer"></i></span>
                                <span>Imprimir ficha</span>
                            </a>
                            <a href="{{ route('matricula.descargar', $matricula->id) }}" class="btn btn-primary">
                                <span><i class="ti ti-file-download"></i></span>
                                <span>Descargar ficha de matrícula</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</div>

{{-- content|end --}}

@endsection
