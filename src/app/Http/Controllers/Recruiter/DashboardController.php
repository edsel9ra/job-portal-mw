<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Candidate;
use App\Models\Application;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalOfertas = Job::count();
        $totalCandidatos = Candidate::count();
        $aplicacionesPendientes = Application::whereNotIn('status', ['Rechazado', 'Contratado'])->count();

        return Inertia::render('Recruiter/Dashboard', [
            'totalOfertas' => $totalOfertas,
            'totalCandidatos' => $totalCandidatos,
            'aplicacionesPendientes' => $aplicacionesPendientes,
        ]);
    }
}