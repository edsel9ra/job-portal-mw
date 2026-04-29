<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\CandidateJobView;
use App\Services\Job\JobService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobCandidateController extends Controller
{
    public function __construct(protected JobService $service)
    {
    }

    /**
     * GET /candidato/ofertas
     * Listado de ofertas abiertas con indicador de si ya aplicó.
     */
    public function index(Request $request)
    {
        $user = request()->user();
        $candidate = $user->candidate;
        abort_unless($candidate, 404, 'No tienes un perfil de candidato. Por favor crea tu currículum primero.');

        $jobs = $this->service->getPublicJobs($request->query('q'));
        // Mapa { job_id => status } con las aplicaciones del candidato
        // Solo cargamos los IDs de la página actual para no hacer queries innecesarias
        $jobIds = $jobs->pluck('id');

        $vistosMap = CandidateJobView::where('candidate_id', $candidate->id)
            ->whereIn('job_id', $jobIds)
            ->pluck('last_seen_at', 'job_id')
            ->toArray();
        $aplicacionesMap = Application::where('candidate_id', $candidate->id)
            ->whereIn('job_id', $jobIds)
            ->pluck('status', 'job_id')
            ->mapWithKeys(fn($status, $jobId) => [(string) $jobId => $status]);

        $tieneCurriculum = $candidate->resume()->exists();
        return Inertia::render('Candidate/Jobs/Index', [
            'jobs' => $jobs,
            'filters' => $request->only('q'),
            'aplicacionesMap' => $aplicacionesMap,
            'tieneCurriculum' => $tieneCurriculum,
            'vistosMap' => $vistosMap,
        ]);
    }

    /**
     * GET /candidato/ofertas/{job}
     * Detalle de una oferta con estado de aplicación del candidato.
     */
    public function show(Job $job)
    {
        abort_if($job->status !== 'Abierta', 404); // Solo se pueden ver ofertas abiertas

        $user = request()->user();
        $candidate = $user->candidate;

        abort_unless($candidate, 404, 'No tienes un perfil de candidato.');

        // ✅ Registrar que el candidato vio la oferta
        CandidateJobView::updateOrCreate(
            [
                'candidate_id' => $candidate->id,
                'job_id' => $job->id,
            ],
            [
                'last_seen_at' => now(),
            ]
        );

        $aplicacion = Application::where('candidate_id', $candidate->id)
            ->where('job_id', $job->id)
            ->first();

        $tieneCurriculum = $candidate->resume()->exists();

        return Inertia::render('Candidate/Jobs/Show', [
            'job' => $job->load('branch:id,name'),
            'aplicacion' => $aplicacion,
            'tieneCurriculum' => $tieneCurriculum,
        ]);
    }
}
