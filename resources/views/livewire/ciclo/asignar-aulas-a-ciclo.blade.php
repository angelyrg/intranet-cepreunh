<div>
    <div class="row">
        <div class="col-12">
            <div class="accordion shadow-sm">
                @foreach ($areas as $area)   
                    <div class="accordion-item border mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button bg-primary-subtle py-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#areaAccordion-{{ $area->id }}" aria-expanded="true"
                                aria-controls="areaAccordion-{{ $area->id }}">
                                <span class="badge bg-primary">
                                    {{ $area->descripcion }}
                                </span>
                            </button>
                        </h2>
                        <div id="areaAccordion-{{ $area->id }}" class="accordion-collapse collapse show">
                            <div class="accordion-body" style="max-height: 550px; overflow-y: auto; ">
                                <div class="row">
                                    @if($ciclo->estado == 1 && Auth::user()->can('ciclo.configurar_aulas'))
                                    <div class="col-12 col-lg-6">
                                        <div class="card shadow">
                                            <div class="card-header">
                                                <h5 class="card-title">Aulas disponibles</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-4">
                                                    <div class="text-end mb-1">
                                                        {{-- <button class="btn btn-success btn-sm" wire:click="asignarTodasLasAulas">
                                                            <span>Asignar todas las aulas</span>
                                                            <span><i class="ti ti-arrows-right"></i></span>
                                                        </button> --}}
                                                    </div>
                                    
                                                    <ul class="list-group mt-2 border">
                                                        @foreach($aulas as $aula)
                                                        @if(!in_array($aula->id, $aulasAsignadas))
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            {{ $aula->descripcion }}
                                                            <button class="btn btn-primary btn-sm" wire:click="asignarAula({{ $aula->id }}, {{ $area->id }})">
                                                                Asignar
                                                                <i class="ti ti-arrow-right"></i>
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
                                    <div class="col-12 @if($ciclo->estado == 1 && Auth::user()->can('ciclo.configurar_aulas')) col-lg-6 @endif">
                                        <div class="card shadow">
                                            @if($ciclo->estado == 1 && Auth::user()->can('ciclo.configurar_aulas'))
                                            <div class="card-header">
                                                <h5 class="card-title">Aulas asignadas al ciclo</h5>
                                            </div>
                                            @endif
                                            <div class="card-body">
                                                <div class="mb-4">
                                                    @if($ciclo->estado == 1 && Auth::user()->can('ciclo.configurar_aulas'))
                                                    <div class="mb-1">
                                                        {{-- <button class="btn btn-warning btn-sm" wire:click="quitarTodasLasAulas">
                                                            <span><i class="ti ti-arrows-left"></i></span>
                                                            <span>Quitar todas las aulas</span>
                                                        </button> --}}
                                                    </div>
                                                    @endif
                                    
                                                    <ul class="list-group mt-2 border">
                                                        @foreach($aulasAsignadas as $aulaId)
                                                            @php
                                                                $aulaCiclo = \App\Models\Intranet\AulaCiclo::with('aula')->where('aula_id', $aulaId)->where('area_id', $area->id)->first();
                                                            @endphp
                                                            @if ($aulaCiclo)
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <span>
                                                                        {{ $aulaCiclo->aula->descripcion}}
                                                                    </span>
                                                                    @if($ciclo->estado == 1 && Auth::user()->can('ciclo.configurar_aulas'))
                                                                    <button class="btn btn-danger btn-sm" wire:click="quitarAula({{ $aulaCiclo->aula?->id ?? ''}})">
                                                                        <i class="ti ti-arrow-left"></i>
                                                                        Quitar
                                                                    </button>
                                                                    @endif
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>