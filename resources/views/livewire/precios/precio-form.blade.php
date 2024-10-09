<div>
    <x-modal-bt modalSize="modal-lg" modalNombre="{{ $id ? 'Editar precio' : 'Agregar precio' }}">        
        <form wire:submit.prevent="save">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">                            
                        <label for="area_id" class="form-label">Área</label>
                        <select id="area_id" wire:model.defer="area_id" class="form-select">
                            <option value="">Seleccione un área</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->descripcion }}</option>
                            @endforeach
                        </select>
                        @error('area_id') <div class="text-danger">{{ $message }}</div>  @enderror
                    </div>
                    <div class="col-12">                            
                        <label for="forma_de_pago_id" class="form-label">Forma de pago</label>
                        <select id="forma_de_pago_id" wire:model.defer="forma_de_pago_id" class="form-select">
                            <option value="">Seleccione una forma de pago</option>
                            @foreach ($formas_de_pago as $forma_de_pago)
                                <option value="{{ $forma_de_pago->id }}">{{ $forma_de_pago->descripcion }}</option>
                            @endforeach
                        </select>
                        @error('forma_de_pago_id') <div class="text-danger">{{ $message }}</div>  @enderror
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-4 ">
                            <label for="monto" class="form-label">Monto</label>
                            <input type="number" step="0.01" id="monto" wire:model.defer="monto" class="form-control">
                            @error('monto') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-4 ">
                            <label for="fraccionado" class="form-label">¿El monto de fraccionado?</label>
                            <input type="checkbox" id="fraccionado" wire:model.defer="fraccionado" class="form-control">
                            @error('fraccionado') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" wire:click.prevent="closeModal">CANCELAR</button>
                <button type="submit" class="btn bg-primary-subtle text-primary">{{ $id ? 'ACTUALIZAR' : 'REGISTRAR'}}</button>
            </div>
        </form>
    </x-modal-bt>
</div>