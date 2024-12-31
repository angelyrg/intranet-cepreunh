<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Intranet\EmpleadoController;
use App\Http\Controllers\Intranet\PermissionController;
use App\Http\Controllers\Intranet\RolController;
use App\Http\Controllers\Intranet\RolPermisoController;
use App\Http\Controllers\Intranet\UsuarioController;
use App\Livewire\Estudiante\EstudianteList;
use App\Livewire\RolesPermisos\AsignarPermisoRol;
use App\Livewire\RolesPermisos\RolComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/estudiantes', EstudianteList::class)->name('estudiantes.index');
});

// Roles y perisos 
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('roles', RolController::class)->except(['create', 'show', 'destroy'])->names('roles');
    Route::resource('permisos', PermissionController::class)->except(['create', 'show', 'destroy'])->names('permisos');
    Route::resource('usuarios', UsuarioController::class)->except(['create', 'show', 'destroy'])->names('usuarios');
    Route::resource('empleados', EmpleadoController::class)->except(['create', 'show', 'destroy'])->names('empleados');

    Route::get('roles/{roleId}/permisos', AsignarPermisoRol::class)->name('roles.permisos');
    
});

require __DIR__.'/intranet/auth.php';
require __DIR__.'/intranet/intranet.php';
// require __DIR__.'/intranet/user.php';

// Route::fallback(function () {
//     return view('errors.404');
// });
