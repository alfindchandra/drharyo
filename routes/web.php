<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/antrian', [HomeController::class, 'store'])->name('antrian.store');
Route::get('/jam-praktek', [HomeController::class, 'getJamPraktek'])->name('jam-praktek');
Route::get('/antrian-by-dokter', [HomeController::class, 'getAntrianByDokter'])->name('antrian.by-dokter');
