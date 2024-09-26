<div>
    <x-modal-bt modalSize="modal-lg" :modalNombre="$id ? 'Editar estudiante' : 'Agregar estudiante'">        
        <form wire:submit.prevent="save">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">                            
                        <div class="form-group mb-4 ">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" id="nombres" wire:model="nombres" class="form-control">
                            @error('nombres') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">                            
                        <div class="form-group mb-4 ">
                            <label for="apellido_paterno" class="form-label">Apellido paterno</label>
                            <input type="text" id="apellido_paterno" wire:model="apellido_paterno" class="form-control">
                            @error('apellido_paterno') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">                            
                        <div class="form-group mb-4 ">
                            <label for="apellido_materno" class="form-label">Apellido materno</label>
                            <input type="text" id="apellido_materno" wire:model="apellido_materno" class="form-control">
                            @error('apellido_materno') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">                            
                        <div class="form-group mb-4 ">
                            <label for="correo_institucional" class="form-label">Correo institucional</label>
                            <input type="text" id="correo_institucional" wire:model="correo_institucional" class="form-control">
                            @error('correo_institucional') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">                            
                        <div class="form-group mb-4 ">
                            <label for="telefono_personal" class="form-label">Teléfono personal</label>
                            <input type="text" id="telefono_personal" wire:model="telefono_personal" class="form-control">
                            @error('telefono_personal') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn bg-primary-subtle text-primary">REGISTRAR</button>
                <button type="button" class="btn btn-light" wire:click="closeModal">CANCELAR</button>
            </div>
        </form>
    </x-modal-bt>
</div>
