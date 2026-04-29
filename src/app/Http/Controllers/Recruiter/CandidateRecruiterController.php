<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\UpdateApplicationRequest;
use App\Models\Application;
use App\Models\Candidate;
use App\Services\Application\ApplicationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CandidateRecruiterController extends Controller
{
    public function __construct(protected ApplicationService $service){}

    // ────────────────────────────────────────────────────────────
    //  GET /reclutador/candidatos
    //  Lista paginada de candidatos que han aplicado a mis ofertas.
    // ────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $candidates = $this->service->listCandidatesForRecruiter(
            auth()->id(),
            $request->query('q')
        );

        return Inertia::render('Recruiter/Candidates/Index', [
            'candidates' => $candidates,
            'filters'    => $request->only('q'),
        ]);
    }

    // ────────────────────────────────────────────────────────────
    //  GET /reclutador/candidatos/{candidate}/profile   (JSON)
    //  Perfil completo del candidato: curriculum + sus aplicaciones.
    //  Llamado vía fetch desde el modal del frontend.
    // ────────────────────────────────────────────────────────────
    public function profile(Candidate $candidate)
    {
        // Verificar que este candidato haya aplicado a alguno de mis jobs
        $tieneAplicacion = Application::where('candidate_id', $candidate->id)
            ->whereHas('job', fn($q) => $q->where('user_id', auth()->id()))
            ->exists();

        abort_unless($tieneAplicacion, 403, 'No tienes acceso a este candidato.');

        $data = $this->service->candidateProfileForRecruiter($candidate, auth()->id());

        return response()->json($data);
    }

    // ────────────────────────────────────────────────────────────
    //  PATCH /reclutador/aplicaciones/{application}/status
    //  Cambia el estado de una aplicación.
    // ────────────────────────────────────────────────────────────
    public function updateStatus(UpdateApplicationRequest $request, Application $application)
    {
        $validated = $request->validated();

        $this->service->updateStatus(
            $application,
            $validated['status'],
            $validated['rejection_reason']  ?? null,
            isset($validated['interview_count']) ? (int) $validated['interview_count'] : null,
        );

        return response()->json(['message' => 'Estado actualizado correctamente.']);
    }
}