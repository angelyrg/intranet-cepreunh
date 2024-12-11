@extends('intranet.layouts.app')

@section('content')
    @livewire('empleado.empleado-list')
@endsection
    
@section('scripts')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/tools.js') }}"></script>

<script>

function notifyToastr(message, type, title = '') {
    toastr[type](message, title);    
}

document.addEventListener('livewire:initialized', () => {
    Livewire.on('show-alert', (event) => {
        Swal.fire({
            title: '¡Éxito!',
            text: event.message,
            icon: 'success',
            confirmButtonText: 'OK'
        });
    });

    Livewire.on('showNotify', (data) => {
        var response = data[0];

        notifyToastr(response.msg, response.type, 'Empleado');
        
    });

});

function initializeTooltips() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
}

// Inicializar tooltips cuando la página carga
document.addEventListener('DOMContentLoaded', function () {
    initializeTooltips();
});

// Volver a inicializar tooltips después de una actualización de Livewire
document.addEventListener('livewire:load', function () {
    initializeTooltips();
});

// Volver a inicializar tooltips después de cada actualización de Livewire
document.addEventListener('livewire:updated', function () {
    initializeTooltips();
});


// jneskenz => cortapapeles|start

Livewire.on('copyToClipboard', event => {
    const texto = event[0]?.texto;
    
    if (texto) {
        navigator.clipboard.writeText(texto).then(() => {
            showToastr('Correo copiado', 'success');
        }).catch(err => {
            console.error('Error al copiar el texto: ', err);
        });
    } else {
        console.error('Texto indefinido o vacío');
    }
});

// jneskenz => cortapapeles|end

</script>

@endsection