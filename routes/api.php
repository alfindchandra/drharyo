<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiHomeController;

Route::prefix('v1')->group(function () {
    Route::get('/cabang', [ApiHomeController::class, 'getCabang']);
    Route::get('/dokter', [ApiHomeController::class, 'getDokter']);
    Route::get('/schedule', [ApiHomeController::class, 'getSchedule']);
    Route::get('/antrian-count', [ApiHomeController::class, 'getAntrianCount']);
    Route::post('/antrian', [ApiHomeController::class, 'storeAntrian']); // This handles the form submission
});