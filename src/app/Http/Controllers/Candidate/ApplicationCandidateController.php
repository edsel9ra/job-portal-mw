<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\CreateApplicationRequest;
use App\Models\Application;
use App\Models\Job;
use App\Models\Candidate;
use App\Services\Application\ApplicationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationCandidateController extends Controller
{
    public function __construct(protected ApplicationService $service)
    {
    }

    // ────────────────────────────────────────────────────────────
    //  GET /candidato/aplicaciones
    //  Historial de aplicaciones del candidato con filtro por status.
    // ────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $candidate = $this->candidate();
        $status = $request->query('status');

        // Validar que el status del filtro sea válido (si viene)
        if ($status && !in_array($status, Application::STATUSES)) {
            $status = null;
        }

        $applications = $this->service->listByCandidate($candidate, $status);
        $counts = $this->service->countByStatus($candidate);
        return Inertia::render('Candidate/Applications/Index', [
            'aplicaciones' => $applications,
            'conteo' => $counts,
            'statuses' => Application::STATUSES,
            'filters' => $request->only('status'),
        ]);
    }

    // ══════════════════════════════════════════════════════════════
    //  MÉTODO show() — agregar en ApplicationCandidateController
    // ══════════════════════════════════════════════════════════════
    public function show(Application $application)
    {
        $this->authorizeApplication($application);

        $application->load(['job.branch:id,name']);

        return Inertia::render('Candidate/Applications/Show', [
            'aplicacion' => $application,
        ]);
    }

    // ────────────────────────────────────────────────────────────
    //  POST /candidato/aplicaciones
    //  Crea una nueva aplicación.
    // ────────────────────────────────────────────────────────────
    public function store(CreateApplicationRequest $request)
    {
        $candidate = $this->candidate();
        $job = Job::findOrFail($request->validated()['job_id']);

        $this->service->apply($candidate, $job, $request->validated()['cover_letter'] ?? null);

        return redirect()
            ->route('candidato.applications.index')
            ->with('success', '¡Aplicación enviada correctamente!');
    }

    // ────────────────────────────────────────────────────────────
    //  DELETE /candidato/aplicaciones/{application}
    //  El candidato retira su aplicación (solo si está en 'Aplicado').
    // ────────────────────────────────────────────────────────────
    public function destroy(Application $application)
    {
        $this->authorizeApplication($application);

        $this->service->withdraw($application);

        return redirect()
            ->route('candidato.applications.index')
            ->with('success', 'Aplicación retirada.');
    }

    // ── Helpers privados ─────────────────────────────────────────

    private function candidate(): Candidate
    {
        $candidate = auth()->user()->candidate;
        abort_unless($candidate !== null, 404, 'Perfil de candidato no encontrado.');
        return $candidate;
    }

    /**
     * Verifica que la aplicación pertenece al candidato autenticado.
     */
    private function authorizeApplication(Application $application): void
    {
        abort_unless(
            (int) $application->candidate_id === (int) $this->candidate()->id,
            403,
            'No tienes permiso para modificar esta aplicación.'
        );
    }
}
