<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Intranet\CarreraController;
use App\Http\Controllers\Intranet\AreaController;
use App\Http\Controllers\Intranet\AsignaturaCicloController;
use App\Http\Controllers\Intranet\AsignaturaController;
use App\Http\Controllers\Intranet\CarreraCicloController;
use App\Http\Controllers\Intranet\CicloController;
use App\Http\Controllers\Intranet\DocenteController;
use App\Http\Controllers\Intranet\PermissionController;
use App\Http\Controllers\Intranet\PrecioController;
use App\Http\Controllers\Intranet\SedeController;
use App\Models\Intranet\AsignaturaCiclo;
use App\Models\Intranet\CarreraCiclo;
use Spatie\Permission\Contracts\Permission;

// Rutas protegidas con autenticación y confirmación de correo verificado
Route::middleware(['auth', 'verified'])->group(function () {

    Route::resource('permisos', PermissionController::class)->except(['create','show','destroy'])->names('permisos');

    Route::resource('sedes', SedeController::class)->except(['create','show','destroy'])->names('sedes');
    Route::delete('sedes/{sede}/eliminar', [SedeController::class, 'eliminar'])->name('sedes.eliminar');

    Route::resource('areas', AreaController::class)->except(['create', 'show', 'destroy'])->names('areas');
    Route::patch('areas/{area}/eliminar', [AreaController::class, 'eliminar'])->name('areas.eliminar');

    Route::resource('carreras', CarreraController::class)->names('carreras');
    Route::resource('docentes', DocenteController::class)->names('docentes');

    Route::resource('asignaturas', AsignaturaController::class)->except(['create','show','destroy'])->names('asignaturas');
    Route::patch('asignaturas/{asignatura}/eliminar', [AsignaturaController::class, 'eliminar'])->name('asignaturas.eliminar');

    Route::resource('ciclos', CicloController::class)->except(['create','show','destroy'])->names('ciclos');
    Route::delete('ciclos/{ciclo}/eliminar', [CicloController::class, 'eliminar'])->name('ciclos.eliminar');

    Route::resource('carreraciclo', CarreraCicloController::class)->except(['create','show','destroy'])->names('carreraciclo');
    Route::patch('carreraciclo/{carreraciclo}/eliminar', [CarreraCicloController::class, 'eliminar'])->name('carreraciclo.eliminar');
    Route::post('carreraciclo/carreras', [CarreraCicloController::class, 'carreras'])->name('carreraciclo.carreras');

    Route::resource('asignaturaciclo', AsignaturaCicloController::class)->except(['create','show','destroy'])->names('asignaturaciclo');
    Route::patch('asignaturaciclo/{asignaturaciclo}/eliminar', [AsignaturaCicloController::class, 'eliminar'])->name('asignaturaciclo.eliminar');
    Route::post('asignaturaciclo/asignaturas', [AsignaturaCicloController::class, 'asignaturas'])->name('asignaturaciclo.asignaturas');

    Route::resource('precios', PrecioController::class)->names('precios');

});
