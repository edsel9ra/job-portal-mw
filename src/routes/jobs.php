<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────────────────────────────
//  RUTAS PÚBLICAS — sin autenticación
//  Cualquier visitante puede ver el listado y el detalle.
// ─────────────────────────────────────────────────────────────────
Route::prefix('ofertas')->name('jobs.')->group(function () {
    Route::get('/', [JobController::class, 'publicIndex'])->name('index');
    Route::get('/{job}', [JobController::class, 'publicShow'])->name('show');
});
