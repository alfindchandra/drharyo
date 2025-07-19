<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return redirect()->route('antrian.form');
});

Route::get('/antrian', [HomeController::class, 'showAntrianForm'])->name('antrian.form');
