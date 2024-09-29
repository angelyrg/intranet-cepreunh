<?php

use App\Http\Controllers\Api\MatriculaVirtual\MatriculaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return 'API';
});


Route::prefix('matricula_virtual')->group(function () {

    Route::post('validacion', [MatriculaController::class, 'procesarMatricula']);

});
