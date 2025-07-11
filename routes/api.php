<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiHomeController;

Route::prefix('v1')->group(function () {
    // Get master data
    Route::get('/cabang', [ApiHomeController::class, 'getCabang']);
    Route::get('/dokter', [ApiHomeController::class, 'getDokter']);
    
    // Antrian routes
    Route::post('/antrian', [ApiHomeController::class, 'createAntrian']);
    Route::get('/antrian', [ApiHomeController::class, 'getAntrian']);
    Route::put('/antrian/{id}/status', [ApiHomeController::class, 'updateStatusAntrian']);
    Route::delete('/antrian/{id}', [ApiHomeController::class, 'deleteAntrian']);
}); 