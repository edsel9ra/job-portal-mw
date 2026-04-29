<?php

namespace App\Services\Resume;

use App\Models\Resume;
use App\Models\Candidate;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ResumeService
{
    /**
     * Obtiene el resume del candidato o null si no tiene.
     */
    public function getByCandidate(Candidate $candidate): ?Resume
    {
        return Resume::where('candidate_id', $candidate->id)->first();
    }

    /**
     * Crea el resume del candidato.
     * Si viene PDF (pdf_file) lo almacena en storage/app/public/resumes/
     */
    public function create(Candidate $candidate, array $data): Resume
    {
        [$pdfPath, $pdfMime, $pdfSize] = $this->storePdfIfPresent($data);

        return Resume::create([
            'candidate_id' => $candidate->id,
            'summary' => $data['summary'] ?? null,

            'work_experience' => $data['work_experience'] ?? [],
            'education' => $data['education'] ?? [],
            'skills' => $data['skills'] ?? [],
            'certifications' => $data['certifications'] ?? [],
            'languages' => $data['languages'] ?? [],

            'pdf_path' => $pdfPath,
            'pdf_mime' => $pdfMime,
            'pdf_size' => $pdfSize,
        ]);
    }

    /**
     * Actualiza el resume.
     * Si viene nuevo PDF, elimina el anterior y guarda el nuevo.
     */
    public function update(Resume $resume, array $data): Resume
    {
        // Si llega nuevo PDF
        if (!empty($data['pdf_file']) && $data['pdf_file'] instanceof UploadedFile) {
            // elimina el anterior
            $this->deletePdfIfExists($resume);

            // guarda el nuevo
            [$pdfPath, $pdfMime, $pdfSize] = $this->storePdfIfPresent($data);

            $data['pdf_path'] = $pdfPath;
            $data['pdf_mime'] = $pdfMime;
            $data['pdf_size'] = $pdfSize;
        }

        // Nunca guardar el UploadedFile en BD
        unset($data['pdf_file']);

        $resume->update([
            'summary' => $data['summary'] ?? $resume->summary,

            // si no vienen en el request, conserva; si vienen, actualiza (aunque sean arrays vacíos)
            'work_experience' => array_key_exists('work_experience', $data) ? ($data['work_experience'] ?? []) : $resume->work_experience,
            'education' => array_key_exists('education', $data) ? ($data['education'] ?? []) : $resume->education,
            'skills' => array_key_exists('skills', $data) ? ($data['skills'] ?? []) : $resume->skills,
            'certifications' => array_key_exists('certifications', $data) ? ($data['certifications'] ?? []) : $resume->certifications,
            'languages' => array_key_exists('languages', $data) ? ($data['languages'] ?? []) : $resume->languages,

            'pdf_path' => $data['pdf_path'] ?? $resume->pdf_path,
            'pdf_mime' => $data['pdf_mime'] ?? $resume->pdf_mime,
            'pdf_size' => $data['pdf_size'] ?? $resume->pdf_size,
        ]);

        return $resume->fresh();
    }

    /**
     * Elimina el resume y su PDF asociado.
     */
    public function delete(Resume $resume): void
    {
        $this->deletePdfIfExists($resume);
        $resume->delete();
    }

    /**
     * Elimina solo el PDF del resume sin borrar el registro.
     */
    public function removePdf(Resume $resume): Resume
    {
        $this->deletePdfIfExists($resume);

        $resume->update([
            'pdf_path' => null,
            'pdf_mime' => null,
            'pdf_size' => null,
        ]);

        return $resume->fresh();
    }

    /**
     * Guarda pdf_file (si viene) y retorna [path, mime, size].
     */
    private function storePdfIfPresent(array $data): array
    {
        $pdfPath = null;
        $pdfMime = null;
        $pdfSize = null;

        if (!empty($data['pdf_file']) && $data['pdf_file'] instanceof UploadedFile) {
            /** @var UploadedFile $file */
            $file = $data['pdf_file'];

            $pdfPath = $file->store('resumes', 'public');
            $pdfMime = $file->getClientMimeType() ?: $file->getMimeType();
            $pdfSize = $file->getSize();
        }

        return [$pdfPath, $pdfMime, $pdfSize];
    }

    /**
     * Borra el PDF actual del disco si existe.
     */
    private function deletePdfIfExists(Resume $resume): void
    {
        if (!empty($resume->pdf_path)) {
            Storage::disk('public')->delete($resume->pdf_path);
        }
    }
}