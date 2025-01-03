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

    
    <script>
        // Función para formatear el tiempo en formato hh:mm:ss (24 horas)
      function formatTimeInput(input) {
        let value = input.value.replace(/[^0-9]/g, ''); // Eliminar todo lo que no sea números
        
        // Limitar a 6 caracteres como máximo (hh:mm:ss)
        if (value.length > 6) {
          value = value.slice(0, 6);
        }
    
        // Validar las horas (00 a 23)
        if (value.length >= 2) {
          let hours = value.slice(0, 2);
          if (parseInt(hours) > 23) {
            hours = '23'; // Ajustar a 23 si el valor es mayor
          }
          value = hours + value.slice(2);
        }
    
        // Validar los minutos (00 a 59)
        if (value.length >= 5) {
          let minutes = value.slice(3, 5);
          if (parseInt(minutes) > 59) {
            minutes = '59'; // Ajustar a 59 si el valor es mayor
          }
          value = value.slice(0, 3) + minutes + value.slice(5);
        }
    
        // Validar los segundos (00 a 59)
        if (value.length === 8) {
          let seconds = value.slice(6, 8);
          if (parseInt(seconds) > 59) {
            seconds = '59'; // Ajustar a 59 si el valor es mayor
          }
          value = value.slice(0, 6) + seconds;
        }
    
        // Agregar los ":" en las posiciones correctas
        if (value.length >= 3 && value.length <= 4) {
          value = value.slice(0, 2) + ':' + value.slice(2);
        } else if (value.length >= 5 && value.length <= 6) {
          value = value.slice(0, 2) + ':' + value.slice(2, 4) + ':' + value.slice(4);
        }
    
        input.value = value;
      }
    
      // Añadir el evento de input a cada campo
      document.getElementById('presente_inicio').addEventListener('input', function() {
        formatTimeInput(this);
      });
      document.getElementById('presente_fin').addEventListener('input', function() {
        formatTimeInput(this);
      });
      document.getElementById('tarde_inicio').addEventListener('input', function() {
        formatTimeInput(this);
      });
      document.getElementById('tarde_fin').addEventListener('input', function() {
        formatTimeInput(this);
      });
    </script>
</div>