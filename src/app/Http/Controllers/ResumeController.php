<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Resume\CreateResumeRequest;
use App\Http\Requests\Resume\UpdateResumeRequest;
use App\Services\Resume\ResumeService;
use App\Models\Resume;
use App\Models\Candidate;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;

class ResumeController extends Controller
{
    public function __construct(protected ResumeService $service)
    {
    }

    // ────────────────────────────────────────────────────────────
    //  GET /candidato/resume
    //  Muestra el resume del candidato.
    //  Si no tiene, redirige a crear.
    // ────────────────────────────────────────────────────────────
    public function show()
    {
        $candidate = $this->candidate();
        $resume = $this->service->getByCandidate($candidate);

        if (!$resume) {
            return redirect()->route('candidato.resume.create');
        }

        return Inertia::render('Candidate/Resume/Show', [
            'resume' => $resume,
        ]);
    }

    // ────────────────────────────────────────────────────────────
    //  GET /candidato/resume/crear
    //  Formulario vacío para crear el resume.
    //  Si ya tiene, redirige a editar.
    // ────────────────────────────────────────────────────────────
    public function create()
    {
        $candidate = $this->candidate();
        $resume = $this->service->getByCandidate($candidate);

        if ($resume) {
            return redirect()->route('candidato.resume.edit', $resume);
        }

        return Inertia::render('Candidate/Resume/Create', [
            'levels' => $this->languageLevels(),
        ]);
    }

    // ────────────────────────────────────────────────────────────
    //  POST /candidato/resume
    //  Persiste el nuevo resume.
    // ────────────────────────────────────────────────────────────
    public function store(CreateResumeRequest $request): RedirectResponse
    {
        $candidate = $this->candidate();

        $this->service->create($candidate, $request->validated());

        return redirect()
            ->route('candidato.resume.show')
            ->with('success', '¡Curriculum creado correctamente!');
    }

    // ────────────────────────────────────────────────────────────
    //  GET /candidato/resume/{resume}/editar
    //  Formulario precargado con los datos actuales.
    // ────────────────────────────────────────────────────────────
    public function edit(Resume $resume)
    {
        // Aunque authorize() del request ya lo protege, una verificación
        // extra aquí garantiza que la vista nunca se muestre a otro candidato.
        $this->authorizeResume($resume);

        return Inertia::render('Candidate/Resume/Edit', [
            'resume' => $resume,
            'levels' => $this->languageLevels(),
        ]);
    }

    // ────────────────────────────────────────────────────────────
    //  PUT /candidato/resume/{resume}
    //  Actualiza el resume existente.
    // ────────────────────────────────────────────────────────────
    public function update(UpdateResumeRequest $request, Resume $resume): RedirectResponse
    {
        $this->service->update($resume, $request->validated());

        return redirect()
            ->route('candidato.resume.show')
            ->with('success', '¡Curriculum actualizado correctamente!');
    }

    // ────────────────────────────────────────────────────────────
    //  DELETE /candidato/resume/{resume}
    //  Elimina el resume completo (incluye PDF en disco).
    // ────────────────────────────────────────────────────────────
    public function destroy(Resume $resume): RedirectResponse
    {
        $this->authorizeResume($resume);

        $this->service->delete($resume);

        return redirect()
            ->route('candidato.dashboard')
            ->with('success', 'Curriculum eliminado.');
    }

    // ────────────────────────────────────────────────────────────
    //  DELETE /candidato/resume/{resume}/pdf
    //  Elimina solo el PDF sin borrar el registro.
    // ────────────────────────────────────────────────────────────
    public function destroyPdf(Resume $resume)
    {
        $this->authorizeResume($resume);

        $this->service->removePdf($resume);

        return back()->with('success', 'PDF eliminado correctamente.');
    }

    // ── Helpers privados ─────────────────────────────────────────

    /**
     * Devuelve el Candidate del usuario autenticado.
     * Aborta con 404 si el usuario no tiene perfil de candidato.
     */
    private function candidate(): Candidate
    {
        $candidate = auth()->user()->candidate;

        abort_unless($candidate !== null, 404, 'Perfil de candidato no encontrado.');

        return $candidate;
    }

    /**
     * Verifica que el resume pertenezca al candidato autenticado.
     * Aborta con 403 si no es el dueño.
     */
    private function authorizeResume(Resume $resume): void
    {
        $candidate = $this->candidate();

        abort_unless(
            (int) $resume->candidate_id === (int) $candidate->id,
            403,
            'No tienes permiso para modificar este curriculum.'
        );
    }

    /**
     * Niveles de idioma disponibles (única fuente de verdad compartida
     * con las vistas Create y Edit).
     */
    private function languageLevels(): array
    {
        return ['Básico', 'Intermedio', 'Avanzado', 'Nativo'];
    }

    /**
     * GET /candidato/curriculum/{resume}/pdf/preview
     * Muestra el PDF generado en el navegador (inline).
     */
    public function preview(Resume $resume)
    {
        $this->authorizeResume($resume);

        $pdf = $this->buildPdf($resume);

        // stream() → el navegador lo muestra inline (visor nativo del browser)
        return $pdf->stream("curriculum_{$resume->id}.pdf");
    }

    /**
     * GET /candidato/curriculum/{resume}/pdf/download
     * Descarga el PDF generado directamente.
     */
    /*public function download(Resume $resume)
    {
        $this->authorizeResume($resume);

        $pdf = $this->buildPdf($resume);

        // download() → fuerza la descarga del archivo
        return $pdf->download("curriculum_{$resume->id}.pdf");
    }*/ //--- IGNORE ---

    // ── Helpers privados ─────────────────────────────────────────

    /**
     * Construye el PDF con dompdf a partir de la vista Blade.
     */
    private function buildPdf(Resume $resume): \Barryvdh\DomPDF\PDF
    {
        $candidate = $resume->candidate()->with('user')->first();
        $initials = $this->initials($candidate->user->name);

        $photoBase64 = null;

        if (!empty($candidate?->photo)) {
            $photoPath = storage_path('app/public/' . $candidate->photo);

            if (file_exists($photoPath)) {
                $mimeType = mime_content_type($photoPath);
                $imageData = base64_encode(file_get_contents($photoPath));
                $photoBase64 = "data:{$mimeType};base64,{$imageData}";
            }
        }

        return Pdf::loadView('pdf.resume', compact('resume', 'candidate', 'initials', 'photoBase64'))
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', false)
            ->setOption('defaultFont', 'DejaVu Sans');
    }

    /**
     * Genera las iniciales del nombre (máx. 2 letras).
     */
    private function initials(string $name): string
    {
        return collect(explode(' ', $name))
            ->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))
            ->take(2)
            ->implode('');
    }
}
