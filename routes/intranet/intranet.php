<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Intranet\CarreraController;
use App\Http\Controllers\Intranet\AreaController;
use App\Http\Controllers\Intranet\AsignaturaCicloController;
use App\Http\Controllers\Intranet\AsignaturaController;
use App\Http\Controllers\Intranet\AulaController;
use App\Http\Controllers\Intranet\CarreraCicloController;
use App\Http\Controllers\Intranet\CicloController;
use App\Http\Controllers\Intranet\DocenteController;
use App\Http\Controllers\Intranet\EstudianteController;
use App\Http\Controllers\Intranet\MatriculaController;
use App\Http\Controllers\Intranet\PermissionController;
use App\Http\Controllers\Intranet\PrecioController;
use App\Http\Controllers\Intranet\SedeController;
use App\Models\Intranet\AsignaturaCiclo;
use App\Models\Intranet\Carrera;
use App\Models\Intranet\CarreraCiclo;
use App\Models\Intranet\FormaDePago;
use Spatie\Permission\Contracts\Permission;

// Rutas protegidas con autenticación y confirmación de correo verificado
Route::middleware(['auth', 'verified'])->group(function () {

    Route::resource('permisos', PermissionController::class)->except(['create','show','destroy'])->names('permisos');

    Route::resource('sedes', SedeController::class)->except(['create','show','destroy'])->names('sedes');
    Route::delete('sedes/{sede}/eliminar', [SedeController::class, 'eliminar'])->name('sedes.eliminar');

    Route::resource('areas', AreaController::class)->except(['create', 'show', 'destroy'])->names('areas');
    Route::patch('areas/{area}/eliminar', [AreaController::class, 'eliminar'])->name('areas.eliminar');

    Route::get('carreras/{area_id}', function ($area_id) {
        $carreras = Carrera::where('area_id', $area_id)->get();
        return response()->json($carreras);
    });
    
    // Route::get('precios/{sede_id}/{grupo_id}', function ($area_id) {
    //     $modalidades = FormaDePago::where('area_id', $area_id)->get();
    //     return response()->json($carreras);
    // });    


    Route::resource('carreras', CarreraController::class)->names('carreras');
    Route::resource('docentes', DocenteController::class)->names('docentes');

    Route::resource('asignaturas', AsignaturaController::class)->except(['create','show','destroy'])->names('asignaturas');
    Route::patch('asignaturas/{asignatura}/eliminar', [AsignaturaController::class, 'eliminar'])->name('asignaturas.eliminar');

    Route::resource('ciclos', CicloController::class)->except(['create','destroy'])->names('ciclos');
    Route::delete('ciclos/{ciclo}/eliminar', [CicloController::class, 'eliminar'])->name('ciclos.eliminar');
    Route::get('ciclos/{ciclo}/matricula', [CicloController::class, 'matricula'])->name('ciclos.matricula');
    Route::get('ciclos/{ciclo}/create_precios', [CicloController::class, 'create_precios'])->name('ciclos.create_precios');
    Route::get('ciclos/{ciclo}/asignar_carreras', [CicloController::class, 'asignar_carreras'])->name('ciclos.asignar_carreras');
    Route::get('ciclos/{ciclo}/asignar_asignaturas', [CicloController::class, 'asignar_asignaturas'])->name('ciclos.asignar_asignaturas');
    
    Route::post('matricula/buscar_dni', [MatriculaController::class, 'buscar_dni'])->name('matricula.buscar_dni');
    Route::get('matricula/datos-personales', [MatriculaController::class, 'datos_personales'])->name('matricula.datos_personales');
    Route::post('matricula/store_estudiante', [MatriculaController::class, 'store_estudiante'])->name('matricula.store_estudiante');
    Route::get('matricula/create', [MatriculaController::class, 'create'])->name('matricula.create');
    Route::post('matricula/store', [MatriculaController::class, 'store'])->name('matricula.store');
    Route::get('matricula/{matricula}/show', [MatriculaController::class, 'show'])->name('matricula.show');
    Route::get('matricula/{matricula}/edit', [MatriculaController::class, 'edit'])->name('matricula.edit');
    Route::put('matricula/{matricula}/update', [MatriculaController::class, 'update'])->name('matricula.update');
    // Route::post('matricula/update', [MatriculaController::class, 'update'])->name('matricula.update');
    Route::get('matricula/{matricula}/descargar', [MatriculaController::class, 'descargar'])->name('matricula.descargar');
    Route::get('matricula/{matricula}/imprimir', [MatriculaController::class, 'imprimir'])->name('matricula.imprimir');
    Route::delete('matricula/{matricula}/delete', [MatriculaController::class, 'delete'])->name('matricula.delete');

    // Route::resource('matriculas', MatriculaController::class)->names('matriculas');

    Route::get('estudiante', [EstudianteController::class, 'index'])->name('estudiante.index');
    Route::get('estudiante/{estudiante}/show', [EstudianteController::class, 'show'])->name('estudiante.show');
    Route::get('estudiante/{estudiante}/edit', [EstudianteController::class, 'edit'])->name('estudiante.edit');
    Route::put('estudiante/{estudiante}/update', [EstudianteController::class, 'update'])->name('estudiante.update');

    Route::resource('carreraciclo', CarreraCicloController::class)->except(['create','show','destroy'])->names('carreraciclo');
    Route::patch('carreraciclo/{carreraciclo}/eliminar', [CarreraCicloController::class, 'eliminar'])->name('carreraciclo.eliminar');
    Route::post('carreraciclo/carreras', [CarreraCicloController::class, 'carreras'])->name('carreraciclo.carreras');

    Route::resource('asignaturaciclo', AsignaturaCicloController::class)->except(['create','show','destroy'])->names('asignaturaciclo');
    Route::patch('asignaturaciclo/{asignaturaciclo}/eliminar', [AsignaturaCicloController::class, 'eliminar'])->name('asignaturaciclo.eliminar');
    Route::post('asignaturaciclo/asignaturas', [AsignaturaCicloController::class, 'asignaturas'])->name('asignaturaciclo.asignaturas');

    Route::resource('precios', PrecioController::class)->names('precios');

    Route::resource('aulas', AulaController::class)->except(['create', 'show', 'destroy'])->names('aulas');
    Route::delete('aulas/{aula}/eliminar', [AulaController::class, 'eliminar'])->name('aulas.eliminar');

});
