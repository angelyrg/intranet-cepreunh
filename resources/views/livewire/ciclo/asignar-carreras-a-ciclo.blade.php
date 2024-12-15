<div class="rounded-2">
    <div class="">
        <div class="row">
            @if($ciclo->estado == 1)
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
            @endif
            <div class="col-12 @if($ciclo->estado == 1) col-md-6 @endif">
                <div class="card shadow">
                    @if($ciclo->estado == 1)
                    <div class="card-header">
                        <h4 class="card-title">Carreras asignadas al ciclo</h4>
                    </div>
                    @endif
                    <div class="card-body">
                        <div class="mb-4">
                            @if($ciclo->estado == 1)
                            <div class="text-end mb-1 mt-2">
                                <button class="btn btn-warning btn-sm" wire:click="quitarTodasLasCarreras">
                                    <span><i class="ti ti-arrows-left"></i></span>
                                    <span>Quitar todas las carreras</span>
                                </button>
                            </div>
                            @endif
                            
        
                            <ul class="list-group">
                                @foreach($carrerasAsignadas as $carreraId)
                                    @php
                                        $carrera = \App\Models\Intranet\Carrera::find($carreraId);
                                    @endphp
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            {{-- TODO: MOSTRAR AREA DE LA CARRERA --}}
                                            {{-- <span class="badge text-primary bg-primary-subtle">
                                                {{ $carrera->area->descripcion }}
                                            </span> --}}
                                            <span>
                                                {{ $carrera->descripcion }}
                                            </span>
                                        </div>
                                        @if($ciclo->estado == 1)
                                        <button class="btn btn-danger btn-sm" wire:click="quitarCarrera({{ $carrera->id }})">
                                            Quitar
                                        </button>
                                        @endif
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
