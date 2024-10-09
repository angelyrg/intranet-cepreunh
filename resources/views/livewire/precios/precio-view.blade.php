<div>
    {{-- Breadcrumb|start  --}}
    <x-breadcrumb 
        title="Lista de {{ $title }}" 
        parent-url="#"
        parent-label="Configuración del Sistema"
        current-label="Precios"
        button-label="NUEVO"
        action="showForm"
    />
    {{-- Breadcrumb|end  --}}

    {{-- Content|start --}}
    <div class="card w-100 position-relative overflow-hidden">
        <div class="px-4 py-3 border-bottom">
            <h4 class="card-title mb-0">Lista de {{ $title }}</h4>
        </div>
        {{-- <div class="card-header">
            <input wire:model.lazy="search" class="form-control" placeholder="Buscar registros">
        </div> --}}
        <div class="card-body">
            @if($precios->count())
                <div class="table-responsive table-xs mb-2 border rounded-1">
                    <table class="table text-nowrap table-borderless table-bordered table-hover table-striped mb-0 align-middle" id="tblUsuarios">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th><h6 class="fs-4 fw-semibold mb-0 text-uppercase">Acciones</h6></th>
                                <th><h6 class="fs-4 fw-semibold mb-0">Forma de pago</h6></th>
                                <th><h6 class="fs-4 fw-semibold mb-0">Ciclo</h6></th>
                                <th><h6 class="fs-4 fw-semibold mb-0">Sede</h6></th>
                                <th><h6 class="fs-4 fw-semibold mb-0">Area</h6></th>
                                <th><h6 class="fs-4 fw-semibold mb-0">Monto</h6></th>
                                <th><h6 class="fs-4 fw-semibold mb-0">Fraccionado</h6></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($precios as $precio)
                                <tr>
                                    <td>
                                        <button type="button" class="btn badge fw-semibold p-1 bg-primary-subtle text-primary"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Más acciones">
                                            <i class="ti ti-menu-4"></i>
                                        </button>
                                        <ul class="dropdown-menu">                                          
                                            <li>
                                                <a class="dropdown-item bg-danger-subtle text-danger py-2" wire:click="delete({{ $precio->id }})" onclick="confirm('¿Estás seguro de eliminar?') || event.stopImmediatePropagation()">
                                                    <i class="ti ti-trash"></i> Eliminar
                                                </a>
                                            </li>                                            
                                        </ul>                                        
                                        <a wire:click="showForm({{ $precio->id }})" class="btn badge fw-semibold py-1 bg-primary-subtle text-primary" title="Editar">
                                            <i class="ti ti-edit"></i>                                        
                                        </a>
                                    </td>
                                    <td>{{ $precio->forma_de_pago_id }}</td>
                                    <td>{{ $precio->ciclo_id }}</td>
                                    <td>{{ $precio->sede_id }}</td>
                                    <td>{{ $precio->area_id }}</td>
                                    <td>{{ $precio->monto }}</td>
                                    <td>{{ $precio->fraccionado }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $precios->links() }}
            @else
                {{ __('No hay registros para mostrar') }}
            @endif
        </div>
    </div>
    {{-- Content|end --}}

    

    {{-- Modal|start --}}
    @if($showModal)
        <livewire:precios.precio-form :precio-id="$id" wire:key="{{ $id ?? 'create' }}" />
    @endif
    {{-- Modal|end --}}
    
</div>