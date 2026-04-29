<?php

namespace App\Services\Application;

use App\Models\Application;
use App\Models\Candidate;
use App\Models\Job;
use Illuminate\Pagination\LengthAwarePaginator;

class ApplicationService
{
    // ════════════════════════════════════════════════════════════
    //  CANDIDATO
    // ════════════════════════════════════════════════════════════

    /**
     * Lista las aplicaciones del candidato con filtro opcional por status.
     */
    public function listByCandidate(Candidate $candidate, ?string $status = null): LengthAwarePaginator
    {
        return Application::with(['job.branch:id,name'])
            ->where('candidate_id', $candidate->id)
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest('applied_at')
            ->paginate(Application::PAGINATE)
            ->withQueryString();
    }

    /**
     * Cuenta las aplicaciones del candidato agrupadas por status.
     * Retorna: ['ALL' => 5, 'Aplicado' => 3, 'Rechazado' => 1, ...]
     */
    public function countByStatus(Candidate $candidate): array
    {
        $counts = Application::where('candidate_id', $candidate->id)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $counts['ALL'] = array_sum($counts);
        return $counts;
    }

    /**
     * Crea una nueva aplicación para el candidato.
     * Precondiciones ya validadas en el FormRequest y el controller.
     */
    public function apply(Candidate $candidate, Job $job, ?string $coverLetter): Application
    {
        return Application::create([
            'candidate_id' => $candidate->id,
            'job_id' => $job->id,
            'cover_letter' => $coverLetter,
            'status' => 'Aplicado',
            'applied_at' => now(),
        ]);
    }

    /**
     * Retira (elimina) la aplicación del candidato.
     * Solo se puede retirar si está en estado 'Aplicado'.
     */
    public function withdraw(Application $application): void
    {
        abort_unless(
            $application->isAplicado(),
            422,
            'Solo puedes retirar una aplicación que esté en estado Aplicado.'
        );
        $application->delete();
    }

    // ════════════════════════════════════════════════════════════
    //  RECLUTADOR
    // ════════════════════════════════════════════════════════════

    /**
     * Lista las aplicaciones de una oferta específica con filtro opcional por status.
     */
    public function listByJob(Job $job, ?string $status = null): LengthAwarePaginator
    {
        return Application::with(['candidate.user:id,name,email'])
            ->where('job_id', $job->id)
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest('applied_at')
            ->paginate(Application::PAGINATE)
            ->withQueryString();
    }

    /**
     * Lista todas las aplicaciones de los jobs del reclutador.
     */
    public function listByRecruiter(int $userId, ?string $status = null): LengthAwarePaginator
    {
        return Application::with(['job:id,name_job', 'candidate.user:id,name,email'])
            ->whereHas('job', fn($q) => $q->where('user_id', $userId))
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest('applied_at')
            ->paginate(Application::PAGINATE)
            ->withQueryString();
    }

    /**
     * Actualiza el estado de una aplicación.
     * - 'Rechazado'  → guarda rejection_reason, limpia interview_count
     * - 'Entrevista' → guarda interview_count,  limpia rejection_reason
     * - Otros        → limpia ambos campos opcionales
     */
    public function updateStatus(
        Application $application,
        string $newStatus,
        ?string $rejectionReason = null,
        ?int $interviewCount = null,
    ): Application {
        abort_unless(
            in_array($newStatus, Application::STATUSES),
            422,
            "El status '{$newStatus}' no es válido."
        );

        $application->update([
            'status' => $newStatus,
            'reviewed_at' => now(),
            'rejection_reason' => $newStatus === 'Rechazado' ? $rejectionReason : null,
            'interview_count' => $newStatus === 'Entrevista' ? $interviewCount : null,
        ]);

        return $application->fresh();
    }

    // ════════════════════════════════════════════════════════════
    //  RECLUTADOR — Candidatos
    // ════════════════════════════════════════════════════════════

    /**
     * Lista candidatos que han aplicado a jobs del reclutador,
     * con búsqueda por nombre o email.
     */
    public function listCandidatesForRecruiter(int $userId, ?string $search = null): LengthAwarePaginator
    {
        return Candidate::with(['user:id,name,email', 'resume'])
            ->whereHas('applications.job', fn($q) => $q->where('user_id', $userId))
            ->when($search, fn($q) => $q->whereHas(
                'user',
                fn($u) =>
                $u->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
            ))
            ->paginate(Application::PAGINATE)
            ->withQueryString();
    }

    /**
     * Devuelve el curriculum y las aplicaciones de un candidato
     * filtradas a los jobs del reclutador.
     */
    public function candidateProfileForRecruiter(Candidate $candidate, int $userId): array
    {
        $candidate->load(['user:id,name,email', 'resume']);

        $applications = Application::with(['job:id,name_job,status'])
            ->where('candidate_id', $candidate->id)
            ->whereHas('job', fn($q) => $q->where('user_id', $userId))
            ->latest('applied_at')
            ->get();

        return [
            'candidate' => [
                'id' => $candidate->id,
                'document_type' => $candidate->document_type,
                'document_number' => $candidate->document_number,
                'phone' => $candidate->phone,
                'birth_date' => $candidate->birth_date,
                'city' => $candidate->city,
                'photo' => $candidate->photo,
                'user' => $candidate->user,
                'resume' => $candidate->resume ? [
                    'id' => $candidate->resume->id,
                    'summary' => $candidate->resume->summary,
                    'work_experience' => $candidate->resume->work_experience,
                    'education' => $candidate->resume->education,
                    'skills' => $candidate->resume->skills,
                    'languages' => $candidate->resume->languages,
                    'pdf_path' => $candidate->resume->pdf_path,
                    'pdf_url' => $candidate->resume->pdf_path
                        ? asset('storage/' . $candidate->resume->pdf_path)
                        : null,
                ] : null,
            ],
            'applications' => $applications,
        ];
    }
}