<div>
    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        {{ session('message') }}
    </div>
    @endif

    <form wire:submit.prevent="submit">
        <div class="row">
            <!-- Modalidad de pago -->
            <div class="col-md-4 mb-3">
                <label for="forma_de_pago_id" class="form-label">Modalidad de pago</label>
                <select wire:model="forma_de_pago_id" id="forma_de_pago_id"
                    class="form-select @error('forma_de_pago_id') is-invalid @enderror" required>
                    <option value="">Seleccione...</option>
                    @foreach ($formasDePago as $modalidad)
                    <option value="{{ $modalidad->id }}">
                        {{ $modalidad->descripcion }}
                    </option>
                    @endforeach
                </select>
                @error('forma_de_pago_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Banco -->
            <div class="col-md-4 mb-3">
                <label for="banco_id" class="form-label">Banco</label>
                <select wire:model="banco_id" id="banco_id" class="form-select @error('banco_id') is-invalid @enderror"
                    required>
                    <option value="">Seleccione...</option>
                    @foreach ($bancos as $banco)
                    <option value="{{ $banco->id }}">
                        {{ $banco->descripcion }}
                    </option>
                    @endforeach
                </select>
                @error('banco_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Fecha y hora de pago -->
            <div class="col-md-4 mb-3">
                <label for="fecha_pago" class="form-label">Fecha y hora de pago</label>
                <input wire:model="fecha_pago" type="datetime-local" id="fecha_pago"
                    class="form-control @error('fecha_pago') is-invalid @enderror" required />
                @error('fecha_pago')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Número de transacción -->
            <div class="col-md-4 mb-3">
                <label for="n_transaccion" class="form-label">Número de transacción</label>
                <input wire:model="n_transaccion" type="text" id="n_transaccion"
                    class="form-control @error('n_transaccion') is-invalid @enderror"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');" required/>
                @error('n_transaccion')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Descripción del pago -->
            <div class="col-md-4 mb-3">
                <label for="descripcion_pago" class="form-label">Descripción del pago</label>
                <input wire:model="descripcion_pago" type="text" id="descripcion_pago"
                    class="form-control @error('descripcion_pago') is-invalid @enderror" required />
                @error('descripcion_pago')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Código de operación -->
            <div class="col-md-4 mb-3">
                <label for="cod_operacion" class="form-label">Código de operación</label>
                <input wire:model="cod_operacion" type="text" id="cod_operacion"
                    class="form-control @error('cod_operacion') is-invalid @enderror" required />
                @error('cod_operacion')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            

            <!-- Monto -->
            <div class="col-md-4 mb-3">
                <label for="monto" class="form-label">Monto</label>
                <input wire:model="monto" type="number" id="monto"
                    class="form-control @error('monto') is-invalid @enderror" required step="0.01" />
                @error('monto')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Comisión -->
            <div class="col-md-4 mb-3">
                <label for="comision" class="form-label">Comisión</label>
                <input wire:model="comision" type="number" id="comision"
                    class="form-control @error('comision') is-invalid @enderror" required step="0.01" value="0" />
                @error('comision')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Monto neto -->
            <div class="col-md-4 mb-3">
                <label for="monto_neto" class="form-label">Monto neto</label>
                <input wire:model="monto_neto" type="number" id="monto_neto"
                    class="form-control @error('monto_neto') is-invalid @enderror" required step="0.01" />
                @error('monto_neto')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Condición de pago -->
            <div class="col-md-4 mb-3">
                <label for="condicion_pago" class="form-label">Condición de pago</label>
                <select wire:model="condicion_pago" id="condicion_pago"
                    class="form-select @error('condicion_pago') is-invalid @enderror" required>
                    <option value="Cancelado" {{ old('condicion_pago')=='Cancelado' ? 'selected' : '' }}>Cancelado
                    </option>
                    <option value="Parcial" {{ old('condicion_pago')=='Parcial' ? 'selected' : '' }}>Parcial</option>
                </select>
                @error('condicion_pago')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Guardar pago</button>
            </div>
        </div>
    </form>
</div>