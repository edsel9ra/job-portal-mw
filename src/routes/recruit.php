<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Recruiter\DashboardController;
use App\Http\Controllers\Recruiter\ApplicationRecruiterController;
use App\Http\Controllers\Recruiter\CandidateRecruiterController;
use Inertia\Inertia;

Route::middleware(['auth', 'role:reclutador'])
    ->prefix('reclutador')
    ->name('reclutador.')
    ->group(function () {
        // Dashboard principal del reclutador
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        // Rutas para gestionar ofertas (index, create, edit, etc.) se definen en jobs.php
        Route::prefix('ofertas')->name('jobs.')->group(function () {
            Route::get('/', [JobController::class, 'index'])->name('index');
            Route::get('/crear', [JobController::class, 'create'])->name('create');
            Route::post('/', [JobController::class, 'store'])->name('store');
            Route::get('/{job}', [JobController::class, 'show'])->name('show');
            Route::get('/{job}/editar', [JobController::class, 'edit'])->name('edit');
            Route::put('/{job}', [JobController::class, 'update'])->name('update');
            Route::delete('/{job}', [JobController::class, 'destroy'])->name('destroy');
            Route::patch('/{job}/status', [JobController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/{job}/duplicar', [JobController::class, 'duplicate'])->name('duplicate');
            Route::get('/{job}/aplicaciones', [ApplicationRecruiterController::class, 'byJob'])->name('aplicaciones');
        });

        // Rutas de aplicaciones del reclutador (ver ApplicationRecruiterController)
        /*Route::prefix('aplicaciones')->name('applications.')->group(function () {
            Route::get('/', [ApplicationRecruiterController::class, 'index'])->name('index');
            Route::patch('/{application}/status', [ApplicationRecruiterController::class, 'updateStatus'])->name('updateStatus');
        });*/

        // Rutas de candidatos del reclutador (ver CandidateRecruiterController)
        Route::prefix('candidatos')->name('candidates.')->group(function () {
            Route::get('/', [CandidateRecruiterController::class, 'index'])->name('index');
            Route::get('/{candidate}/profile', [CandidateRecruiterController::class, 'profile'])->name('profile');
            // Cambio de status de aplicación se maneja en ApplicationRecruiterController para mantener la lógica centralizada
            Route::patch('/aplicaciones/{application}/status', [CandidateRecruiterController::class, 'updateStatus'])->name('applications.updateStatus');
        });
    });