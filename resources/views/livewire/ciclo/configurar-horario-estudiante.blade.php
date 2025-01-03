<div>

    <form wire:submit.prevent="{{ $cicloTieneConfiguracion ? 'actualizarHorarioEstudiante' : 'crearHorarioEstudiante' }}">
        <div class="border border-primary p-2 rounded-2">
            <p class="mb-0">Horario para marcar <strong>PRESENTE</strong> </p> 
            <small>(Incluído el tiempo de tolerancia)</small>

            <div class="form-group mt-2">
                <label for="presente_inicio">Desde</label>
                <input type="text" wire:model="presente_inicio" class="form-control" id="presente_inicio" placeholder="hh:mm:ss">
                @error('presente_inicio') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
    
            <div class="form-group">
                <label for="presente_fin">Hasta</label>
                <input type="text" wire:model="presente_fin" class="form-control" id="presente_fin" placeholder="hh:mm:ss">
                @error('presente_fin') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="border border-warning p-2 rounded-2 mt-2">
            <p>Horario para marcar <strong>TARDE</strong></p>

            <div class="form-group">
                <label for="tarde_inicio">Desde</label>
                <input type="text" wire:model="tarde_inicio" class="form-control" id="tarde_inicio" placeholder="hh:mm:ss">
                @error('tarde_inicio') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
    
            <div class="form-group">
                <label for="tarde_fin">Hasta</label>
                <input type="text" wire:model="tarde_fin" class="form-control" id="tarde_fin" placeholder="hh:mm:ss">
                @error('tarde_fin') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-2">
            <button type="submit" class="btn btn-primary">
                {{ $cicloTieneConfiguracion ? 'Actualizar' : 'Guardar' }}
            </button>
        </div>

        <div class="mt-3">
            @if (session()->has('horario_success'))
                <div class="alert alert-success">
                    {{ session('horario_success') }}
                </div>
            @endif

            @if (session()->has('horario_error'))
            <div class="alert alert-danger">
                {{ session('horario_error') }}
            </div>
            @endif
        </div>

    </form>

</div>