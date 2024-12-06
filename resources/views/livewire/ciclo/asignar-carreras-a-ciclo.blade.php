<div class="card p-0 shadow rounded-2">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Ciclo: <strong>{{ $ciclos->find($cicloId)->descripcion }}</strong></h5>
            <a class="btn btn-outline-primary" href="{{ route('ciclos.show', $cicloId) }}">
                <i class="ti ti-arrow-left"></i>
                <span>Volver</span>
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">
                <!-- Carreras disponibles -->
                <div class="mb-4">
                    <h5>Carreras disponibles</h5>
                    <div class="text-end mb-3">
                        <button class="btn btn-success btn-sm" wire:click="asignarTodasLasCarreras">
                            <span>Asignar todas las carreras</span>
                            <span><i class="ti ti-arrows-right"></i></span>
                        </button>
                    </div>

                    <ul class="list-group">
                        @foreach($carreras as $carrera)
                            @if(!in_array($carrera->id, $carrerasAsignadas))
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge text-primary bg-primary-subtle">
                                            {{ $carrera->area->descripcion }}
                                        </span>
                                        <span>
                                            {{ $carrera->descripcion }}
                                        </span>
                                    </div>
                                    <button class="btn btn-primary btn-sm" wire:click="asignarCarrera({{ $carrera->id }})">
                                        Asignar
                                    </button>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <!-- Carreras asignadas -->
                <div class="mb-4">
                    <h4>Carreras asignadas al ciclo</h4>
                    <button class="btn btn-warning btn-sm" wire:click="quitarTodasLasCarreras">
                        <span><i class="ti ti-arrows-left"></i></span>
                        <span>Quitar todas las carreras</span>
                    </button>

                    <ul class="list-group">
                        @foreach($carrerasAsignadas as $carreraId)
                            @php
                                $carrera = \App\Models\Intranet\Carrera::find($carreraId);
                            @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge text-primary bg-primary-subtle">
                                        {{ $carrera->area->descripcion }}
                                    </span>
                                    <span>
                                        {{ $carrera->descripcion }}
                                    </span>
                                </div>
                                <button class="btn btn-danger btn-sm" wire:click="quitarCarrera({{ $carrera->id }})">
                                    Quitar
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
