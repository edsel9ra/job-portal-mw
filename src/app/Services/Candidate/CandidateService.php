<?php
namespace App\Services\Candidate;

use App\Models\Candidate;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class CandidateService
{
    // Aquí puedes agregar métodos para manejar la lógica de negocio relacionada con los candidatos, como obtener candidatos, crear, actualizar, eliminar, etc.
    public function getAllCandidates(?string $q = null, int $page = 1): LengthAwarePaginator
    {
        return Candidate::when($q, function ($query) use ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        })
            ->latest()
            ->paginate(Candidate::PAGINATE)
            ->withQueryString();
    }

    /**
     * Devuelve un perfil de candidato por su ID.
     */
    public function getCandidateById(int $id): Candidate
    {
        return Candidate::with(['user:id,name,email'])->findOrFail($id);
    }

    /**
     * Crea el perfil extendido del candidato.
     * Si viene una foto, la almacena en storage y guarda la ruta.
     */
    public function createCandidate(array $data): Candidate
    {
        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            $data['photo'] = $data['photo']->store('candidates/photos', 'public');
        }

        $candidate = Candidate::create($data);
        return $candidate->load(['user:id,name,email']);
    }

    /**
     * Actualiza el perfil del candidato.
     * Si se sube una nueva foto, elimina la anterior y guarda la nueva.
     */
    public function updateCandidate(int $id, array $data): Candidate
    {
        $candidate = Candidate::findOrFail($id);

        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            if ($candidate->photo) {
                Storage::disk('public')->delete($candidate->photo);
            }
            $data['photo'] = $data['photo']->store('candidates/photos', 'public');
        }

        $candidate->update($data);
        return $candidate->fresh(['user:id,name,email']);
    }

    /**
     * Elimina el perfil del candidato y su foto de perfil si existe.
     */
    public function deleteCandidate(int $id): void
    {
        $candidate = Candidate::findOrFail($id);

        if ($candidate->photo) {
            Storage::disk('public')->delete($candidate->photo);
        }

        $candidate->delete();
    }

    
}