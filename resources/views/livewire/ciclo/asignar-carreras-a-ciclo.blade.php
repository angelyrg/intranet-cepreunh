<div class="rounded-2">
    <div class="">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="card-title">Carreras disponibles</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="text-end mb-1 mt-2">
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
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="card-title">Carreras asignadas al ciclo</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="text-end mb-1 mt-2">
                                <button class="btn btn-warning btn-sm" wire:click="quitarTodasLasCarreras">
                                    <span><i class="ti ti-arrows-left"></i></span>
                                    <span>Quitar todas las carreras</span>
                                </button>
                            </div>
        
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
    </div>
</div>
