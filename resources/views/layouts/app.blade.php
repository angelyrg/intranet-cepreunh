<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Estudiantes y Profesores</title>
    @livewireStyles
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    @yield('content')
    @livewire('estudiante.estudiante-list')

    @livewireScripts
    <script>
        Livewire.on('showAlert', message => {
            Swal.fire({
                title: '¡Éxito!',
                text: message,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });

        Livewire.on('closeModal', () => {
            // Lógica para cerrar el modal
        });
    </script>
</body>
</html>