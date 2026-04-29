<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Job\CreateJobRequest;
use App\Http\Requests\Job\UpdateJobRequest;
use App\Services\Job\JobService;
use App\Models\Job;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobController extends Controller
{

    public function __construct(protected JobService $service)
    {
    }

    // ──────────────────────────────────────────────────────────────
    //  RUTAS PÚBLICAS  (sin auth)
    //  Cualquier visitante puede ver el listado y el detalle.
    //  El botón "Aplicar" redirige a login si no está autenticado.
    // ──────────────────────────────────────────────────────────────

    /**
     * Listado público de ofertas abiertas.
     * GET /ofertas
     */
    public function publicIndex(Request $request)
    {
        $jobs = $this->service->getPublicJobs(
            $request->query('q'),
            $request->query('page', 1),
        );

        return Inertia::render('Public/Jobs/Index', [
            'jobs' => $jobs,
            'filters' => $request->only('q'),
        ]);
    }

    /**
     * Detalle público de una oferta.
     * GET /ofertas/{job}
     */
    public function publicShow(Job $job)
    {
        // Solo muestra ofertas abiertas al público
        abort_if($job->getAttribute('status') !== 'Abierta', 404);

        return Inertia::render('Public/Jobs/Show', [
            'job' => $job->load('branch:id,name'),
        ]);
    }

    // ──────────────────────────────────────────────────────────────
    //  RUTAS DEL RECLUTADOR  (auth + role:reclutador)
    // ──────────────────────────────────────────────────────────────

    /**
     * CRUD Index — panel del reclutador.
     * GET /reclutador/ofertas
     */
    public function index(Request $request)
    {
        $jobs = $this->service->getAllJobs(
            $request->query('q'),
            $request->query('status'),
        );

        return Inertia::render('Recruiter/Jobs/Index', [
            'jobs' => $jobs,
            'filters' => $request->only('q', 'status'),
        ]);
    }

    /**
     * GET /reclutador/ofertas/crear
     */
    public function create()
    {
        return Inertia::render('Recruiter/Jobs/Create', [
            'branches' => Branch::select('id', 'name')->get(),
        ]);
    }

    /**
     * POST /reclutador/ofertas
     */
    public function store(CreateJobRequest $request)
    {
        $this->service->createJob($request->validated() + ['user_id' => auth()->id()]);

        return redirect()
            ->route('reclutador.jobs.index')
            ->with('success', 'Oferta creada correctamente.');
    }

    /**
     * GET /reclutador/ofertas/{job}
     */
    public function show(Job $job)
    {
        return Inertia::render('Recruiter/Jobs/Show', [
            'job' => $job->load('branch:id,name'),
        ]);
    }

    /**
     * GET /reclutador/ofertas/{job}/editar
     */
    public function edit(Job $job)
    {
        return Inertia::render('Recruiter/Jobs/Edit', [
            'job'      => $job->load('branch:id,name'),
            'branches' => Branch::select('id', 'name')->get(),
        ]);
    }

    /**
     * PUT /reclutador/ofertas/{job}
     */
    public function update(UpdateJobRequest $request, Job $job)
    {
        $this->service->updateJob($job->getAttribute('id'), $request->validated());

        return redirect()
            ->route('reclutador.jobs.show', $job)
            ->with('success', 'Oferta actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    /*public function destroy(string $id)
    {
        //
    }*/

    // ──────────────────────────────────────────────────────────────
    //  ACCIONES AJAX  (Inertia partial / fetch desde el frontend)
    // ──────────────────────────────────────────────────────────────

    /**
     * PATCH /reclutador/ofertas/{job}/status
     * Cambia solo el status desde el selector inline del Show.
     */
    public function updateStatus(Request $request, Job $job)
    {
        $request->validate([
            'status' => 'required|in:Abierta,Pausada,Cerrada',
        ]);

        $job->update(['status' => $request->input('status')]);

        return back()->with('success', 'Estado actualizado.');
    }

    /**
     * POST /reclutador/ofertas/{job}/duplicar
     * Duplica la oferta.
     */
    public function duplicate(Job $job)
    {
        $copy = $this->service->createJob([
            'name_job'      => "{$job->getAttribute('name_job')} (Copia)",
            'description'   => $job->getAttribute('description'),
            'salary'        => $job->getAttribute('salary'),
            'status'        => 'Abierta',
            'contract_type' => $job->getAttribute('contract_type'),
            'branch_id'     => $job->getAttribute('branch_id'),
        ]);

        return redirect()
            ->route('reclutador.jobs.show', $copy)
            ->with('success', 'Oferta duplicada correctamente.');
    }
}
