<?php

use App\Http\Controllers\Candidate\JobCandidateController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\Candidate\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Candidate\ApplicationCandidateController;
use App\Http\Controllers\Candidate\ProfileController;

Route::middleware(['auth', 'role:candidato'])
    ->prefix('candidato')
    ->name('candidato.')
    ->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        // Rutas de perfil de candidato
        Route::get('/perfil/completar', [ProfileController::class, 'create'])->name('profile.create');
        Route::post('/perfil/completar', [ProfileController::class, 'store'])->name('profile.store');
        Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');

        // Rutas de aplicaciones y ofertas (protegidas por middleware de perfil completo)
        Route::middleware('candidate.profile.complete')->group(function () {

            Route::get('/ofertas', [JobCandidateController::class, 'index'])->name('jobs.index');
            Route::get('/ofertas/{job}', [JobCandidateController::class, 'show'])->name('jobs.show');

            Route::prefix('curriculum')->name('resume.')->group(function () {
                Route::get('/', [ResumeController::class, 'show'])->name('show');
                Route::get('/crear', [ResumeController::class, 'create'])->name('create');
                Route::post('/', [ResumeController::class, 'store'])->name('store');
                Route::get('/{resume}/editar', [ResumeController::class, 'edit'])->name('edit');
                Route::put('/{resume}', [ResumeController::class, 'update'])->name('update');
                Route::delete('/{resume}', [ResumeController::class, 'destroy'])->name('destroy');
                Route::delete('/{resume}/pdf', [ResumeController::class, 'destroyPdf'])->name('destroyPdf');

                //Generar PDF del resume
                Route::get('/{resume}/pdf', [ResumeController::class, 'preview'])->name('preview');
                Route::get('/{resume}/pdf/download', [ResumeController::class, 'download'])->name('download');
                Route::get('/{resume}/pdf/preview', [ResumeController::class, 'preview'])->name('pdf.preview');
                Route::get('/{resume}/pdf/download', [ResumeController::class, 'download'])->name('pdf.download');
            });

            Route::prefix('aplicaciones')->name('applications.')->group(function () {
                Route::get('/', [ApplicationCandidateController::class, 'index'])->name('index');
                Route::get('/{application}', [ApplicationCandidateController::class, 'show'])->name('show');
                Route::post('/', [ApplicationCandidateController::class, 'store'])->name('store');
                Route::delete('/{application}', [ApplicationCandidateController::class, 'destroy'])->name('destroy');
            });
        });

    });