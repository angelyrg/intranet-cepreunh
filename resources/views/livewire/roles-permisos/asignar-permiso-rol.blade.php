<div>
    <x-modal-bt modalSize="modal-lg" modalNombre="ASIGNACIÓN DE PERMISOS A ROL" btnClose="closeModal">            
        <div class="modal-body">
            <div class="row justify-content-center">
                <div class="col-md-11">
                    {{-- <div class="card">
                        <div class="card-body p-0">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        AGREGAR PERMISOS
                                    </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Agregue permisos">
                                            <button class="btn btn-success btn-sm">
                                                <i class="fa fa-plus"></i> REGISTRAR
                                            </button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="col-lg-5">
                    <form wire:submit.prevent="save" id="formPermisosDisponibles">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="py-2">
                                    <input wire:model.lazy="search" class="form-control" placeholder="Buscar registro de permisos">
                                </div>                                
                                <div class="py-2">
                                    <table class="table table-sm table-bordered table-hover ">
                                        <thead class="text-center">
                                            <tr>
                                                <th class="fs-2 fw-bold py-1 mb-0" width="20%">ACCIÓN</th>
                                                <th class="fs-2 fw-bold py-1 mb-0">REGISTRO DE PERMISOS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permisosDisponibles as $permiso)
                                            <tr>
                                                <td class="text-center">
                                                    <input wire:model="permisosDisponibles" type="checkbox" name="permiso[]" class="form-check-input me-1" data-id="{{ $permiso->id }}" value="check">
                                                </td>
                                                <td>{{ $permiso->name }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="py-2">
                                    {{ $permisosDisponibles->links() }}
                                </div>
                            </div>
                        </div>                        
                    </form>
                </div>
                <div class="col-lg-1 d-flex flex-column justify-content-center align-items-center">
                    <button type="submit" wire:click="savePermisosAsignados" class="btn btn-success btn-sm my-2">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                    <button type="submit" wire:click="removePermisosAsignados" form="formPermisosAsignados" class="btn btn-danger btn-sm my-2">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                </div>
                <div class="col-lg-5">
                    <form wire:submit.prevent="back" id="formPermisosAsignados">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="py-2">
                                    {{-- <input wire:model.lazy="search" class="form-control" placeholder="Buscar permisos asignados"> --}}
                                </div>
                                <div class="py-2"><
                                    <table class="table table-sm table-bordered table-hover ">
                                        <thead class="text-center">
                                            <tr>
                                                <th class="fs-2 fw-bold py-1 mb-0" width="20%">ACCIÓN</th>
                                                <th class="fs-2 fw-bold py-1 mb-0">PERMISOS ASIGNADOS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permisosAsignados as $permiso)
                                                <tr>
                                                    <td class="text-center">
                                                        <input type="checkbox" name="permiso[]" class="form-check-input me-1" data-id="{{ $permiso->id }}" value="check">
                                                    </td>
                                                    <td>{{ $permiso->name }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="py-2">
                                    {{-- {{ $permisosAsignados->links() }} --}}
                                </div>                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="{{ asset('assets/libs/treeview/tree.min.js') }}"></script>
    </x-modal-bt>

</div>
