<?php

namespace App\Services\Job;

use App\Models\Job;
use Illuminate\Pagination\LengthAwarePaginator;

class JobService
{
    public function getAllJobs(?string $q = null, ?string $status = null): LengthAwarePaginator
    {
        return Job::with(['branch:id,name'])
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name_job', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->when($status, fn($query) => $query->where('status', $status))
            ->latest()
            ->paginate(Job::PAGINATE)
            ->withQueryString();
    }

    /**
     * Ofertas para el listado público — solo Abiertas.
     */

    public function getPublicJobs(?string $q = null, int $page = 1): LengthAwarePaginator
    {
        return Job::with(['branch:id,name'])
            ->where('status', 'Abierta')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name_job', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(Job::PAGINATE)
            ->withQueryString();
    }

    public function getJobById(int $id): Job
    {
        // Lógica para obtener una oferta de trabajo por su ID    
        return Job::with(['branch:id,name'])->findOrFail($id);
    }

    // Aquí puedes agregar métodos para manejar la lógica de negocio relacionada con las ofertas de trabajo, como crear, actualizar, eliminar, etc.
    public function createJob(array $data): Job
    {
        // Lógica para crear una nueva oferta de trabajo
        return Job::create($data);
    }

    public function updateJob(int $id, array $data): Job
    {
        $job = Job::findOrFail($id);
        $job->update($data);
        return $job->fresh(['branch:id,name']);
    }
}