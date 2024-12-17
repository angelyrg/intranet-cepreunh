<div>
    <x-modal-bt modalSize="modal-lg" modalNombre="ASIGNACIÓN DE PERMISOS A ROL" btnClose="closeModal">
        <div class="modal-body">
            <!-- Mensajes de error o éxito -->
            @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <form wire:submit.prevent="assignPermissions">
                <p>
                    <strong>
                        ROL: {{ $roleName }}
                    </strong>
                </p>

                <div class="mb-3">
                    <label class="form-label">Seleccionar Permisos</label><br>
                    @foreach ($permisos as $permiso)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="permission_{{ $permiso->id }}"
                            wire:model="permisosDisponiblesSelect" value="{{ $permiso->name }}">
                        <label class="form-check-label" for="permission_{{ $permiso->id }}">
                            {{ $permiso->name }}
                        </label>
                    </div>
                    @endforeach
                    @error('permisosDisponiblesSelect') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Permisos</button>
            </form>
        </div>
    </x-modal-bt>
</div>