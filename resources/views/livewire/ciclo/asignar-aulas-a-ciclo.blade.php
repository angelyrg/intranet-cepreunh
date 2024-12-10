<div class="">
    <div class="row">
        @if($ciclo->estado == 1)
        <div class="col-12 col-md-6">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title">Aulas disponibles</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="text-end mb-1">
                            <button class="btn btn-success btn-sm" wire:click="asignarTodasLasAulas">
                                <span>Asignar todas las aulas</span>
                                <span><i class="ti ti-arrows-right"></i></span>
                            </button>
                        </div>

                        <ul class="list-group mt-2 border">
                            @foreach($aulas as $aula)
                            @if(!in_array($aula->id, $aulasAsignadas))
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $aula->descripcion }}
                                <button class="btn btn-primary btn-sm"
                                    wire:click="asignarAula({{ $aula->id }})">
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
                    <h5 class="card-title">Aulas asignadas al ciclo</h5>
                </div>
                @endif
                <div class="card-body">
                    <div class="mb-4">
                        @if($ciclo->estado == 1)
                        <div class="mb-1">
                            <button class="btn btn-warning btn-sm" wire:click="quitarTodasLasAulas">
                                <span><i class="ti ti-arrows-left"></i></span>
                                <span>Quitar todas las aulas</span>
                            </button>
                        </div>
                        @endif

                        <ul class="list-group mt-2 border">
                            @foreach($aulasAsignadas as $aulaId)
                            @php
                            $aula = \App\Models\Intranet\Aula::find($aulaId);
                            @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    {{ $aula->descripcion }}
                                </span>
                                @if($ciclo->estado == 1)
                                <button class="btn btn-danger btn-sm"
                                    wire:click="quitarAula({{ $aula->id }})">
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