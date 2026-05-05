<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [JobController::class, 'publicIndex'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* Redirección
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isReclutador()
            ? redirect()->route('reclutador.dashboard')
            : redirect()->route('candidato.dashboard');
    }
    return redirect()->route('login');
});*/

require __DIR__ . '/auth.php';
require __DIR__ . '/jobs.php';
require __DIR__ . '/recruit.php';
require __DIR__ . '/candidate.php';
