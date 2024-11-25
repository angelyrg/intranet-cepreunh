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
<script>

    // other

    // let data = [
    //   {
    //     "id": "0",
    //     "text": "node-0",
    //     "children": [
    //       {
    //           "id": "0-0",
    //           "text": "node-0-0",
    //           "children": [
    //             {
    //                 "id": "0-0-0",
    //                 "text": "node-0-0-0"
    //             },
    //             {
    //                 "id": "0-0-1",
    //                 "text": "node-0-0-1"
    //             },
    //             {
    //                 "id": "0-0-2",
    //                 "text": "node-0-0-2"
    //             }
    //           ]
    //       },
    //       {
    //           "id": "0-1",
    //           "text": "node-0-1",
    //           "children": [
    //             {
    //                 "id": "0-1-0",
    //                 "text": "node-0-1-0"
    //             },
    //             {
    //                 "id": "0-1-1",
    //                 "text": "node-0-1-1"
    //             },
    //             {
    //                 "id": "0-1-2",
    //                 "text": "node-0-1-2"
    //             }
    //           ]
    //       },
    //       {
    //           "id": "0-2",
    //           "text": "node-0-2",
    //           "children": [
    //             {
    //                 "id": "0-2-0",
    //                 "text": "node-0-2-0"
    //             },
    //             {
    //                 "id": "0-2-1",
    //                 "text": "node-0-2-1"
    //             },
    //             {
    //                 "id": "0-2-2",
    //                 "text": "node-0-2-2"
    //             }
    //           ]
    //       }
    //     ]
    //   },
    //   {
    //     "id": "1",
    //     "text": "node-1",
    //     "children": [
    //       {
    //           "id": "1-0",
    //           "text": "node-1-0",
    //           "children": [
    //             {
    //                 "id": "1-0-0",
    //                 "text": "node-1-0-0"
    //             },
    //             {
    //                 "id": "1-0-1",
    //                 "text": "node-1-0-1"
    //             },
    //             {
    //                 "id": "1-0-2",
    //                 "text": "node-1-0-2"
    //             }
    //           ]
    //       },
    //       {
    //           "id": "1-1",
    //           "text": "node-1-1",
    //           "children": [
    //             {
    //                 "id": "1-1-0",
    //                 "text": "node-1-1-0"
    //             },
    //             {
    //                 "id": "1-1-1",
    //                 "text": "node-1-1-1"
    //             },
    //             {
    //                 "id": "1-1-2",
    //                 "text": "node-1-1-2"
    //             }
    //           ]
    //       },
    //       {
    //           "id": "1-2",
    //           "text": "node-1-2",
    //           "children": [
    //             {
    //                 "id": "1-2-0",
    //                 "text": "node-1-2-0"
    //             },
    //             {
    //                 "id": "1-2-1",
    //                 "text": "node-1-2-1"
    //             },
    //             {
    //                 "id": "1-2-2",
    //                 "text": "node-1-2-2"
    //             }
    //           ]
    //       }
    //     ]
    //   },
    //   {
    //     "id": "2",
    //     "text": "node-2",
    //     "children": [
    //       {
    //           "id": "2-0",
    //           "text": "node-2-0",
    //           "children": [
    //             {
    //                 "id": "2-0-0",
    //                 "text": "node-2-0-0"
    //             },
    //             {
    //                 "id": "2-0-1",
    //                 "text": "node-2-0-1"
    //             },
    //             {
    //                 "id": "2-0-2",
    //                 "text": "node-2-0-2"
    //             }
    //           ]
    //       },
    //       {
    //           "id": "2-1",
    //           "text": "node-2-1",
    //           "children": [
    //             {
    //                 "id": "2-1-0",
    //                 "text": "node-2-1-0"
    //             },
    //             {
    //                 "id": "2-1-1",
    //                 "text": "node-2-1-1"
    //             },
    //             {
    //                 "id": "2-1-2",
    //                 "text": "node-2-1-2"
    //             }
    //           ]
    //       },
    //       {
    //           "id": "2-2",
    //           "text": "node-2-2",
    //           "children": [
    //             {
    //                 "id": "2-2-0",
    //                 "text": "node-2-2-0"
    //             },
    //             {
    //                 "id": "2-2-1",
    //                 "text": "node-2-2-1"
    //             },
    //             {
    //                 "id": "2-2-2",
    //                 "text": "node-2-2-2"
    //             }
    //           ]
    //       }
    //     ]
    //   }
    // ]

    // let tree = new Tree('.containertreewview', {
    //     // data: [{ id: '-1', text: 'root', children: data }],
    //     data: data,
    //     closeDepth: 3,
    //     loaded: function () {
    //         this.values = ['0-0-0', '0-1-1'];
    //         console.log(this.selectedNodes);
    //         console.log(this.values);
    //         this.disables = ['0-0-0', '0-0-1', '0-0-2', '1-2']
    //     },
    //     onChange: function () {
    //         console.log(this.values);
    //     }
    // });



</script>


@endsection