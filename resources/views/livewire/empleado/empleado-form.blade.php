<div>    
    <x-modal-bt modalSize="modal-xl" :modalNombre="$id ? 'Editar empleados' : 'Agregar empleados'" btnClose="closeModal">        
        <form wire:submit.prevent="save">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3 ">
                            <label for="departamento_id" class="form-label mb-1 fw-bold fs-2">Departamento</label>
                            <select id="departamento_id" wire:model="departamento_id" class="form-select">
                                <option value="">Seleccione</option>
                                @foreach($departamentos as $departamento)
                                    <option value="{{ $departamento->id }}">{{ $departamento->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3 ">
                            <label for="tipo_documento_id" class="form-label mb-1 fw-bold fs-2">Tipo documento</label>
                            <select id="tipo_documento_id" wire:model="tipo_documento_id" class="form-select">
                                <option value="">Seleccione</option>
                                @foreach($tipo_documentos as $tipo_documento)
                                    <option value="{{ $tipo_documento->id }}">{{ $tipo_documento->descripcion }}</option>
                                @endforeach
                            </select>
                            @error('tipo_documento_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-3 ">
                            <label for="nro_documento" class="form-label mb-1 fw-bold fs-2">Número documento</label>
                            <input type="text" id="nro_documento" wire:model="nro_documento" class="form-control">
                            @error('nro_documento') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                
                    <div class="col-lg-3">                            
                        <div class="form-group mb-3 ">
                            <label for="nombres" class="form-label mb-1 fw-bold fs-2">Nombres</label>
                            <input type="text" id="nombres" wire:model="nombres" class="form-control">
                            @error('nombres') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-3">                            
                        <div class="form-group mb-3 ">
                            <label for="apellido_paterno" class="form-label mb-1 fw-bold fs-2">Apellido paterno</label>
                            <input type="text" id="apellido_paterno" wire:model="apellido_paterno" class="form-control">
                            @error('apellido_paterno') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-3">                            
                        <div class="form-group mb-3 ">
                            <label for="apellido_materno" class="form-label mb-1 fw-bold fs-2">Apellido materno</label>
                            <input type="text" id="apellido_materno" wire:model="apellido_materno" class="form-control">
                            @error('apellido_materno') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-3 ">
                            <label for="telefono_personal" class="form-label mb-1 fw-bold fs-2">Teléfono personal</label>
                            <input type="text" id="telefono_personal" wire:model="telefono_personal" class="form-control">
                            @error('telefono_personal') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group mb-3 ">
                            <label for="whatsapp" class="form-label mb-1 fw-bold fs-2">Whatsapp</label>
                            <input type="text" id="whatsapp" wire:model="whatsapp" class="form-control">
                            @error('whatsapp') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group mb-3 ">
                            <label for="correo_personal" class="form-label mb-1 fw-bold fs-2">Correo personal</label>
                            <input type="text" id="correo_personal" wire:model="correo_personal" class="form-control">
                            @error('correo_personal') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group mb-3 ">
                            <label for="correo_institucional" class="form-label mb-1 fw-bold fs-2">Correo institucional</label>
                            <input type="text" id="correo_institucional" wire:model="correo_institucional" class="form-control">
                            @error('correo_institucional') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-3 ">
                            <label for="estado" class="form-label mb-1 fw-bold fs-2">Estado</label>
                            <select id="estado" wire:model="estado" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="1">Activo</option>
                                <option value="0">Suspendido</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- error -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <button type="button" class="btn btn-light" wire:click.prevent="closeModal">CANCELAR</button>
                <button type="submit" class="btn bg-primary-subtle text-primary">{{ $id ? 'ACTUALIZAR' : 'REGISTRAR'}}</button>
            </div>
        </form>
    </x-modal-bt>
</div>
