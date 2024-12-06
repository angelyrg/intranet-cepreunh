<div class="container mt-5">

    <form wire:submit.prevent="crearGrupo">
        <!-- Nombre del Grupo -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Grupo</label>
            <input type="text" class="form-control" id="nombre" wire:model="grupoPrecio.nombre">
            @error('grupoPrecio.nombre') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Selección de Carreras -->
        <div class="mb-3">
            <label class="form-label">Seleccionar Carreras</label>
            <div class="form-check">
                @foreach($carreras as $carrera)
                    <input type="checkbox" class="form-check-input" wire:model="carrerasSeleccionadas" value="{{ $carrera->id }}">
                    <label class="form-check-label">{{ $carrera->descripcion }}</label>
                @endforeach
            </div>
            @error('carrerasSeleccionadas') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Tabla Precios con Forma de Pago y Bancos -->
        <div class="mb-3">
            <label class="form-label">Precios por Forma de Pago y Banco</label>
            <table class="table table-bordered">
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
                            <th scope="row">{{ $formaDePago->descripcion }}</th>

                            @foreach($bancos as $banco)
                                <td>
                                    <!-- Monto para cada combinación de forma de pago y banco -->
                                    <div class="form-group">
                                        <input type="number" class="form-control" wire:model="precios.{{ $formaDePago->id }}.bancos.{{ $banco->id }}.monto" placeholder="Monto" step="0.01">
                                        @error('precios.*.bancos.*.monto') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Checkbox para desasociar el banco -->
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" wire:model="precios.{{ $formaDePago->id }}.bancos.{{ $banco->id }}.desasociado">
                                        <label class="form-check-label">Desasociar</label>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Botón Enviar -->
        <button type="submit" class="btn btn-primary">Crear Grupo</button>
    </form>
</div>
