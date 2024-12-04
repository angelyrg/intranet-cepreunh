<div>
    <x-modal-bt modalSize="modal-lg" :modalNombre="$id ? 'Editar empleado' : 'Agregar empleado'">
        <form wire:submit.prevent="save">
            @csrf
            <div class="">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="form-group mb-4 ">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" id="nombres" wire:model.defer="nombres" class="form-control">
                            @error('nombres') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Apellido Parterno -->
                    <div class="col-12 col-lg-6">
                        <div class="form-group mb-4">
                            <label for="apellido_paterno" class="form-label">Apellido Parterno</label>
                            <input type="text" id="apellido_paterno" wire:model.defer="apellido_paterno"
                                class="form-control">
                            @error('apellido_paterno') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Apellido Materno -->
                    <div class="col-12 col-lg-6">
                        <div class="form-group mb-4">
                            <label for="apellido_materno" class="form-label">Apellido Materno</label>
                            <input type="text" id="apellido_materno" wire:model.defer="apellido_materno"
                                class="form-control">
                            @error('apellido_materno') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Tipo de Documento -->
                    <div class="col-12 col-lg-6">
                        <div class="form-group mb-4">
                            <label for="tipo_documento_id" class="form-label">Tipo de Documento</label>
                            <select id="tipo_documento_id" wire:model.defer="tipo_documento_id" class="form-select">
                                <option value="">Seleccione</option>
                                @foreach ($tipos_documentos as $tipo_documento)
                                <option value="{{ $tipo_documento->id }}">{{ $tipo_documento->descripcion }}</option>
                                @endforeach
                            </select>
                            @error('tipo_documento_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Número de Documento -->
                    <div class="col-12 col-lg-6">
                        <div class="form-group mb-4">
                            <label for="nro_documento" class="form-label">Número de Documento</label>
                            <input type="text" id="nro_documento" wire:model.defer="nro_documento" class="form-control">
                            @error('nro_documento') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div class="col-12 col-lg-6">
                        <div class="form-group mb-4">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" id="fecha_nacimiento" wire:model.defer="fecha_nacimiento"
                                class="form-control">
                            @error('fecha_nacimiento') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Teléfono Personal -->
                    <div class="col-12 col-lg-6">
                        <div class="form-group mb-4">
                            <label for="telefono_personal" class="form-label">Teléfono Personal</label>
                            <input type="text" id="telefono_personal" wire:model.defer="telefono_personal"
                                class="form-control">
                            @error('telefono_personal') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <div class="col-12 col-lg-6">
                        <div class="form-group mb-4">
                            <label for="whatsapp" class="form-label">WhatsApp</label>
                            <input type="text" id="whatsapp" wire:model.defer="whatsapp" class="form-control">
                            @error('whatsapp') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Correo Personal -->
                    <div class="col-12 col-lg-6">
                        <div class="form-group mb-4">
                            <label for="correo_personal" class="form-label">Correo Personal</label>
                            <input type="email" id="correo_personal" wire:model.defer="correo_personal" class="form-control">
                            @error('correo_personal') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Correo Institucional -->
                    <div class="col-12 col-lg-6">
                        <div class="form-group mb-4">
                            <label for="correo_institucional" class="form-label">Correo Institucional</label>
                            <input type="email" id="correo_institucional" wire:model.defer="correo_institucional"
                                class="form-control">
                            @error('correo_institucional') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Sede -->
                    <div class="col-12 col-lg-6">
                        <div class="form-group mb-4">
                            <label for="sede_id" class="form-label">Sede</label>
                            <select id="sede_id" wire:model.defer="sede_id" class="form-select">
                                <option value="">Seleccione</option>
                                @foreach ($sedes as $sede)
                                <option value="{{ $sede->id }}">{{ $sede->descripcion }}</option>
                                @endforeach
                            </select>
                            @error('sede_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Departamento -->
                    <div class="col-12 col-lg-6">
                        <div class="form-group mb-4">
                            <label for="departamento_id" class="form-label">Departamento</label>
                            <select id="departamento_id" wire:model.defer="departamento_id" class="form-select">
                                <option value="">Seleccione</option>
                                @foreach ($departamentos as $departamento)
                                <option value="{{ $departamento->id }}">{{ $departamento->descripcion }}</option>
                                @endforeach
                            </select>
                            @error('departamento_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" wire:click.prevent="closeModal">CANCELAR</button>
                <button type="submit" class="btn bg-primary-subtle text-primary">{{ $id ? 'ACTUALIZAR' :
                    'REGISTRAR'}}</button>
            </div>
        </form>
    </x-modal-bt>
</div>