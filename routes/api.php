<?php

use App\Http\Controllers\Api\Common\ColegioController;
use App\Http\Controllers\Api\Common\UbigeoController;
use App\Http\Controllers\Api\MatriculaVirtual\CicloController;
use App\Http\Controllers\Api\MatriculaVirtual\MatriculaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return 'API';
});


Route::prefix('matricula_virtual')->group(function () {

    Route::post('validar_pago', [MatriculaController::class, 'validarPago']);
    // Route::post('matricular', [MatriculaController::class, 'procesarMatricula']);
    Route::get('getMatriculaByUUID/{uuid}', [MatriculaController::class, 'getByUUID']);
    Route::get('getFullDataByEstudiante/{dni}', [MatriculaController::class, 'getFullDataByEstudiante']);
    Route::get('getFullMatriculaDataByUUID/{uuid}', [MatriculaController::class, 'getFullDataByUUID']);
    Route::get('getDataForMatricula/{ciclo_id}', [MatriculaController::class, 'getDataForMatricula']);
    Route::get('ciclos', [CicloController::class, 'obtenerCiclosActivos']);
    Route::put('estudiante/{estudiante}', [MatriculaController::class, 'updateDatosEstudiante']);
    Route::post('guardarMatricula', [MatriculaController::class, 'guardarMatriculaVirtual']);
    Route::get('descargarMatricula/{uuid}', [MatriculaController::class, 'descargarFichaDeMatriculaVirtual']);
    Route::get('obtenerFichaMatriculaByDNICiclo/{dni}/{ciclo_id}', [MatriculaController::class, 'getFichaDeMatriculaByEstudiante']);
});


Route::prefix('common')->group(function () {

    /**
     *  /api/common/ubigeos => Devuelve todos los departamentos
     *  /api/common/ubigeos?departamento=01 => Devuelve todos las provincias del departamento 01
     *  /api/common/ubigeos?provincia=0101 => Devuelve todos las distritos de la provincia 0101
     */
    Route::get('ubigeos', [UbigeoController::class, 'index']);
    Route::get('colegios', [ColegioController::class, 'index']);
});
