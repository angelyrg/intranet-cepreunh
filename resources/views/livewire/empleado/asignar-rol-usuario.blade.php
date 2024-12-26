<div>
    <x-modal-bt modalSize="modal-xl" modalNombre="ASIGNACIÓN DE USUARIO Y ROLES" btnClose="closeModalAsignarRolUsuario">
        @if ($empleado->user_id == null)
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12 d-flex align-items-stretch">
                    <div class="card w-100 position-relative overflow-hidden mb-0">

                        <div class="card-body text-center p-4">
                            <h5 class="card-title fw-semibold"> Genere una cuenta de acceso para el empleado:
                                <b>"{{ $nombre_completo }}"</b>
                            </h5>
                            <p class="card-subtitle mb-4">Se creará una cuenta de usuario y contraseña,
                                posteriormente asignará los roles al usuario</p>
                            <div class="text-center">
                                <!-- mostrar svg -->
                                <img src="{{ asset('assets/images/svg/usuario-check.svg') }}" alt="Cargando imagen"
                                    class="img-fluid" width="120" height="120">

                                <form wire:submit.prevent="generarCuenta">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label for="sede_id"
                                                class="form-label fw-semibold text-muted fs-2 mb-0">Sede</label>
                                            <select wire:model="sede_id" id="sede_id" class="form-control">
                                                <option value="">Seleccione</option>
                                                @foreach ($sedes as $id => $descripcion)
                                                    <option value="{{ $id }}">{{ $descripcion }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="correo_personal"
                                                class="form-label fw-semibold text-muted fs-2 mb-0">Correo
                                                electrónico</label>
                                            <input type="email" wire:model="correo_personal" class="form-control"
                                                id="correo_personal" value="{{ $empleado->correo_personal }}">
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="username"
                                                class="form-label fw-semibold text-muted fs-2 mb-0">Usuario</label>
                                            <input type="text" wire:model="username" class="form-control"
                                                id="username" value="{{ $empleado->nro_documento }}">
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="password"
                                                class="form-label fw-semibold text-muted fs-2 mb-0">Contraseña</label>
                                            <input type="text" wire:model="password" class="form-control"
                                                id="password" value="{{ $empleado->nro_documento }}">
                                        </div>
                                    </div>
                                    @error('usuario')
                                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                                    @enderror
                                    <div
                                        class="d-flex align-items-center justify-content-center text-center my-4 gap-3">

                                        <button type="submit" class="btn btn-primary">GENERAR CUENTA</button>
                                        <button type="button" class="btn btn-outline-danger"
                                            wire:click.prevent="closeModalAsignarRolUsuario">CANCELAR</button>
                                    </div>
                                </form>
                                <p class="mb-0">Informe al usuario que cambie la contraseña generada al finalizar
                                    el proceso</p>
                                {{-- <p class="mb-0">La cuenta de usuario y contraseña se enviará al correo electrónico del empleado</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <form wire:submit.prevent="update">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="card w-100 position-relative overflow-hidden mb-0">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <div>
                                        {{-- <h5 class="card-title fw-semibold">Cuenta de usuario</h5> --}}
                                        <p class="card-subtitle">Datos de acceso a intranet</p>
                                    </div>
                                    <div class="ms-auto flex-shrink-0">
                                        {{-- <button type="submit" class="btn btn-primary">ACTUALIZAR</button> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <label for="sede_id" class="form-label fw-semibold">Sede</label>
                                    <select wire:model="sede_id" id="sede_id" class="form-select">
                                        <option value="">Seleccione</option>
                                        @foreach ($sedes as $id => $descripcion)
                                            <option value="{{ $id }}">{{ $descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="correo_personal" class="form-label fw-semibold">Correo
                                        electrónico</label>
                                    <input type="email" wire:model="correo_personal" class="form-control"
                                        id="correo_personal">
                                </div>
                                <div class="mb-4">
                                    <label for="username" class="form-label fw-semibold">Usuario</label>
                                    <input type="text" wire:model="username" class="form-control" id="username">
                                </div>
                                <div class="">
                                    <label for="password" class="form-label fw-semibold">Contraseña</label>
                                    <input type="password" wire:model="password" class="form-control" id="password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="card w-100 position-relative overflow-hidden mb-0">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="card-subtitle">Asignar rol al usuario</p>
                                    </div>
                                    <div class="ms-auto flex-shrink-0">
                                        {{-- <button type="submit" class="btn btn-info">ACTUALIZAR</button> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <label for="role_id" class="form-label fw-semibold">Rol</label>
                                    <select wire:model.lazy="role_id" id="role_id" class="form-select">
                                        <option value="">Seleccione</option>
                                        @foreach ($roles as $rol)
                                            <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="text-center">                                    
                                        <div class="mt-4">
                                            @if (count($permisos) > 0)
                                            <table class="table table-hover table-sm">
                                                
                                                <thead>
                                                    <tr>
                                                        <th>Permisos</th>
                                                        <th>Aplicación</th>
                                                    </tr>
                                                </thead>
                                                <tbody>                                                        
                                                    @foreach ($permisos as $permiso)
                                                    <tr>
                                                        <td>{{ $permiso->name }}</td>
                                                        <td>{{ $permiso->guard_name }}</td>
                                                    </tr>
                                                    @endforeach                                                        
                                                </tbody>
                                                
                                            </table>
                                            @else
                                                <div class="py-10"><i>Sin permisos</i></div>
                                            @endif
                                        </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>                
                </div>                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">ACTUALIZAR</button>
                <button type="button" class="btn btn-light" wire:click.prevent="closeModalAsignarRolUsuario">CERRAR</button>
            </div>
        </form>
        @endif
    </x-modal-bt>
</div>
