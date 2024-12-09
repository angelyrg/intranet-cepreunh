<div>
    <x-modal-bt modalSize="modal-lg" :modalNombre="$id ? 'Editar permiso' : 'Agregar permiso'" btnClose="closeModal">        
        <form wire:submit.prevent="save">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">                            
                        <div class="form-group mb-4 ">
                            <label for="name" class="form-label">Descripción</label>
                            <input type="text" id="name" wire:model="name" class="form-control">
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn bg-primary-subtle text-primary">{{ $id ? 'ACTUALIZAR' : 'REGISTRAR'}}</button>
                <button type="button" class="btn btn-light" wire:click.prevent="closeModal">CANCELAR</button>
            </div>
        </form>
    </x-modal-bt>
</div>
