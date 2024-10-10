<div>
    <x-modal-bt modalSize="modal-xl" modalNombre="ASIGNACIÓN DE USUARIO Y ROLES" btnClose="closeModalAsignarRolUsuario">
        <form wire:submit.prevent="save">
            @csrf
            <div class="modal-body">
                <div class="row">
                    @if ($empleado->user_id == null)
                    <div class="col-lg-12 d-flex align-items-stretch">
                        <div class="card w-100 position-relative overflow-hidden mb-0">
                            <div class="card-body text-center p-4">
                                <h5 class="card-title fw-semibold">Genere una cuenta de acceso para el empleado: <b>"{{ $nombre_completo }}"</b></h5>
                                <p class="card-subtitle mb-4">Se creará una cuenta de usuario y contraseña, posteriormente asignará los roles al usuario</p>
                                <div class="text-center">
                                    <!-- mostrar svg -->
                                    <img src="{{ asset('assets/images/svg/usuario-check.svg') }}" alt="Cargando imagen" class="img-fluid" width="120" height="120">

                                    <form wire:submit.prevent="generarCuenta">
                                        <div class="d-flex align-items-center justify-content-center text-center my-4 gap-3">
                                            <div class="">
                                                <label for="exampleInputPassword1" class="form-label fw-semibold text-muted fs-2 mb-0">Correo
                                                    electrónico</label>
                                                <input type="email" class="form-control" id="exampleInputPassword1" value="{{ $empleado->correo_personal }}">
                                            </div>
                                            <div class="">
                                                <label for="exampleInputPassword2"
                                                    class="form-label fw-semibold text-muted fs-2 mb-0">Usuario</label>
                                                <input type="text" class="form-control" id="exampleInputPassword2" value="{{ $empleado->nro_documento }}">
                                            </div>
                                            <div class="">
                                                <label for="exampleInputPassword3"
                                                    class="form-label fw-semibold text-muted fs-2 mb-0">Contraseña</label>
                                                <input type="password" class="form-control" id="exampleInputPassword3" value="{{ $empleado->nro_documento }}">
                                            </div>                                        
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center text-center my-4 gap-3">
                                            
                                            <button class="btn btn-primary">GENERAR CUENTA</button>
                                            <button class="btn btn-outline-danger">CANCELAR</button>
                                        </div>
                                    </form>
                                    <p class="mb-0">La cuenta de usuario y contraseña se enviará al correo electrónico del empleado</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="card w-100 position-relative overflow-hidden mb-0">
                            <div class="card-body p-4">
                                <h5 class="card-title fw-semibold">Cuenta de usuario</h5>
                                <p class="card-subtitle mb-4">Esta cuenta se utiliza para acceder a la intranet</p>
                                <form>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label fw-semibold">Correo
                                            electrónico</label>
                                        <input type="email" class="form-control" id="exampleInputPassword1"
                                            value="{{ $empleado->correo_personal }}">
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword2"
                                            class="form-label fw-semibold">Usuario</label>
                                        <input type="text" class="form-control" id="exampleInputPassword2"
                                            value="{{ $empleado->nro_documento }}">
                                    </div>
                                    <div class="">
                                        <label for="exampleInputPassword3"
                                            class="form-label fw-semibold">Contraseña</label>
                                        <input type="password" class="form-control" id="exampleInputPassword3"
                                            value="{{ $empleado->nro_documento }}">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-stretch">
                        <div class="card w-100 position-relative overflow-hidden mb-0">
                            <div class="card-body p-4">
                                <h5 class="card-title fw-semibold">Asignación de roles</h5>
                                <p class="card-subtitle mb-4">Asigna los roles al usuario</p>
                                <div class="text-center">
                                    <img src="../assets/images/profile/user-1.jpg" alt=""
                                        class="img-fluid rounded-circle" width="120" height="120">
                                    <div class="d-flex align-items-center justify-content-center my-4 gap-3">
                                        <button class="btn btn-primary">Upload</button>
                                        <button class="btn btn-outline-danger">Reset</button>
                                    </div>
                                    <p class="mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"
                    wire:click.prevent="closeModalAsignarRolUsuario">CANCELAR</button>
                <button type="submit"
                    class="btn bg-primary-subtle text-primary">{{ $id ? 'ACTUALIZAR' : 'REGISTRAR' }}</button>
            </div>
        </form>

    </x-modal-bt>
</div>
