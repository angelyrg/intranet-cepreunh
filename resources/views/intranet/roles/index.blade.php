@extends('intranet.layouts.app')

@section('css')
<style>
    body.modal-open {
        overflow: hidden; /* Evita el scroll del body al abrir el modal */
    }

    .modal-body {
        max-height: calc(100vh - 200px); /* Limita la altura del modal */
        overflow-y: auto; /* Habilita scroll solo en el cuerpo del modal si es necesario */
    }
</style>
@endsection

@section('content')
    @livewire('roles-permisos.rol-list')
@endsection
    
@section('scripts')


<script src="{{ asset('assets/libs/treeview/tree.min.js') }}"></script>

@endsection