<?php

use App\Livewire\Estudiante\EstudianteList;
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

require __DIR__.'/intranet/auth.php';
require __DIR__.'/intranet/intranet.php';
// require __DIR__.'/intranet/user.php';
