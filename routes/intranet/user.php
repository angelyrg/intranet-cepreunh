<?php

use Illuminate\Routing\Route;

Route::get('/users', function () {
    return view('intranet.users');
});