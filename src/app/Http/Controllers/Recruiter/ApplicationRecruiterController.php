<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\UpdateApplicationRequest;
use App\Models\Application;
use App\Models\Job;
use App\Services\Application\ApplicationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationRecruiterController extends Controller
{
    public function __construct(protected ApplicationService $service){}

    // ────────────────────────────────────────────────────────────
    //  GET /reclutador/aplicaciones
    //  Todas las aplicaciones de todos los jobs del reclutador.
    // ────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $status = $request->query('status');

        if ($status && ! in_array($status, Application::STATUSES)) {
            $status = null;
        }

        $aplicaciones = $this->service->listByRecruiter(auth()->id(), $status);

        return Inertia::render('Recruiter/Applications/Index', [
            'aplicaciones' => $aplicaciones,
            'statuses'     => Application::STATUSES,
            'filters'      => $request->only('status'),
        ]);
    }

    // ────────────────────────────────────────────────────────────
    //  GET /reclutador/ofertas/{job}/aplicaciones
    //  Aplicaciones de una oferta específica.
    // ────────────────────────────────────────────────────────────
    public function byJob(Request $request, Job $job)
    {
        $this->authorizeJob($job);

        $status       = $request->query('status');
        $aplicaciones = $this->service->listByJob($job, $status);

        return Inertia::render('Recruiter/Applications/ByJob', [
            'job'          => $job->only('id', 'name_job', 'status'),
            'aplicaciones' => $aplicaciones,
            'statuses'     => Application::STATUSES,
            'filters'      => $request->only('status'),
        ]);
    }

    // ────────────────────────────────────────────────────────────
    //  PATCH /reclutador/aplicaciones/{application}/status
    //  Cambia el status de una aplicación.
    // ────────────────────────────────────────────────────────────
    public function updateStatus(UpdateApplicationRequest $request, Application $application)
    {
        $this->service->updateStatus(
            $application,
            $request->validated()['status'],
            $request->validated()['rejection_reason'] ?? null,
        );

        return back()->with('success', 'Estado de la aplicación actualizado.');
    }

    // ── Helpers privados ─────────────────────────────────────────

    /**
     * Verifica que la oferta pertenece al reclutador autenticado.
     */
    private function authorizeJob(Job $job): void
    {
        abort_unless(
            (int) $job->user_id === (int) auth()->id(),
            403,
            'No tienes permiso para gestionar esta oferta.'
        );
    }
}
