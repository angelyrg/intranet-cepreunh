<div >
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    @if($gruposPrecios->isEmpty())
                    <p class="text-center">No hay grupos de precios creados para este ciclo.</p>
                    @else
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Carreras</th>
                                <th scope="col">Precios</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gruposPrecios as $grupo)
                            <tr>
                                <td class="py-auto">
                                    @foreach($grupo->carreras as $carrera)
                                    <span class="badge bg-primary mb-1">{{ $carrera->descripcion }}</span><br>
                                    @endforeach
                                </td>
                                <td>

                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Forma de Pago / Banco</th>
                                                @foreach($bancos as $banco)
                                                <th>{{ $banco->descripcion }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($formasDePago as $formaDePago)
                                            <tr>
                                                <td><strong>{{ $formaDePago->descripcion }}</strong></td>
                                    
                                                @foreach($bancos as $banco)
                                                @php
                                                // Buscar el precio para esta forma de pago y banco específico
                                                $precio = $grupo->precios->firstWhere(function ($precio) use ($formaDePago, $banco) {
                                                return $precio->forma_de_pago_id == $formaDePago->id && $precio->banco_id == $banco->id;
                                                });
                                                @endphp
                                    
                                                <td>
                                                    @if($precio)
                                                    <span class="badge bg-success">S/{{ $precio->monto }}</span>
                                                    @else
                                                    <small class="badge bg-secondary fst-italic">No asignado</small>
                                                    @endif
                                                </td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form wire:submit.prevent="crearGrupo">
        
                <div class="row">
                    <div class="col-12 d-flex justify-content-center align-items-end gap-3">
                        <div class="form-group w-100">
                            <label for="sedeId">Seleccione una Sede</label>
                            <select wire:model="sedeId" id="sedeId" class="form-select">
                                <option value="">Seleccione</option>
                                @foreach($sedes as $sede)
                                    <option value="{{ $sede->id }}">{{ $sede->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary px-4">Guardar</button>
                        </div>
                    </div>
                </div>
        
                <div class="row mt-4">
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="">
                                    <label class="form-label">Seleccionar Carreras</label>
                                
                                    <!-- Checkbox para seleccionar/deseleccionar todas las carreras -->
                                    <div class="form-check">
                                        <input type="checkbox" id="seleccionar-todas" class="form-check-input"
                                            wire:click="seleccionarTodas('{{ count($carrerasSeleccionadas) === count($carreras) ? 0 : 1 }}')"
                                            wire:checked="{{ count($carrerasSeleccionadas) === count($carreras) ? 'true' : 'false' }}">
                                        <label class="form-check-label" for="seleccionar-todas">Seleccionar todas</label>
                                    </div>
                                    <hr class="my-1">
                                
                                    <!-- Carreras -->
                                    @foreach($carreras as $carrera)
                                    <div class="form-check">
                                        <input type="checkbox" id="carrera-{{ $carrera->id }}" class="form-check-input"
                                            wire:model="carrerasSeleccionadas" value="{{ $carrera->id }}">
                                        <label class="form-check-label" for="carrera-{{ $carrera->id }}">{{ $carrera->descripcion }}</label>
                                    </div>
                                    @endforeach
                                
                                    @error('carrerasSeleccionadas')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-9">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="">
                                    <label class="form-label">Precios por Forma de Pago y Banco</label>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-stripped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col"></th>
                                                    @foreach($bancos as $banco)
                                                    <th scope="col">{{ $banco->descripcion }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($formasDePago as $formaDePago)
                                                <tr>
                                                    <th scope="row">
                                                        <span class="my-auto">{{ $formaDePago->descripcion }}</span>
                                                    </th>
                                
                                                    @if ($bancos->isNotEmpty())
                                                    @foreach($bancos as $banco)
                                                    <td>
                                                        <!-- Monto para cada combinación de forma de pago y banco -->
                                                        <div class="form-group">
                                                            <input type="number" class="form-control"
                                                                wire:model="precios.{{ $formaDePago->id }}.bancos.{{ $banco->id }}.monto"
                                                                placeholder="Monto" step="0.01">
                                                            @error('precios.*.bancos.*.monto') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                
                                                        <!-- Checkbox para desasociar el banco -->
                                                        {{-- <div class="form-check">
                                                            <input type="checkbox" class="form-check-input"
                                                                wire:model="precios.{{ $formaDePago->id }}.bancos.{{ $banco->id }}.desasociado">
                                                            <label class="form-check-label">No disponible</label>
                                                        </div> --}}
                                                    </td>
                                                    @endforeach
                                                    @else
                                                    <td>
                                                        <span class="text-muted fst-italic">
                                                            No hay banco
                                                        </span>
                                                    </td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>                
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
