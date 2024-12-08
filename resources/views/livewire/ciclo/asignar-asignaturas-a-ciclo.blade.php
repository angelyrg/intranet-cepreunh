<div class="">
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title">Asignaturas disponibles</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="text-end mb-1">
                            <button class="btn btn-success btn-sm" wire:click="asignarTodasLasAsignaturas">
                                <span>Asignar todas las asignaturas</span>
                                <span><i class="ti ti-arrows-right"></i></span>
                            </button>
                        </div>
    
                        <ul class="list-group mt-2 border">
                            @foreach($asignaturas as $asignatura)
                                @if(!in_array($asignatura->id, $asignaturasAsignadas))
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $asignatura->descripcion }}
                                        <button class="btn btn-primary btn-sm" wire:click="asignarAsignatura({{ $asignatura->id }})">
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
                    <h5 class="card-title">Asignaturas asignadas al ciclo</h5>
                </div>
                <div class="card-body">
                    <!-- Asignaturas asignadas -->
                    <div class="mb-4">
                        <div class="mb-1">
                            <button class="btn btn-warning btn-sm" wire:click="quitarTodasLasAsignaturas">
                                <span><i class="ti ti-arrows-left"></i></span>
                                <span>Quitar todas las asignaturas</span>
                            </button>
                        </div>
    
                        <ul class="list-group mt-2 border">
                            @foreach($asignaturasAsignadas as $asignaturaId)
                                @php
                                    $asignatura = \App\Models\Intranet\Asignatura::find($asignaturaId);
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $asignatura->descripcion }}
                                    <button class="btn btn-danger btn-sm" wire:click="quitarAsignatura({{ $asignatura->id }})">
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
