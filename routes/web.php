<?php

use App\Http\Controllers\Intranet\RolPermisoController;
use App\Livewire\Estudiante\EstudianteList;
use App\Livewire\RolesPermisos\RolComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/estudiantes', EstudianteList::class)->name('estudiantes.index');
});

// Roles y perisos 
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('roles-permisos', RolPermisoController::class)->except(['create', 'show', 'destroy'])->names('roles-permisos');
});

require __DIR__.'/intranet/auth.php';
require __DIR__.'/intranet/intranet.php';
// require __DIR__.'/intranet/user.php';

Route::fallback(function () {
    return view('errors.404');
});
