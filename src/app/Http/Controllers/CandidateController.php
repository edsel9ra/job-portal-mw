<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Candidate\CandidateService;
use App\Models\Candidate;
use App\Requests\Candidate\CreateCandidateRequest;
use App\Requests\Candidate\UpdateCandidateRequest;
use Inertia\Inertia;

class CandidateController extends Controller
{
    public function __construct(protected CandidateService $service)
    {
    }

    /**
     * Lista todos los perfiles de candidatos (uso del reclutador).
     */
    public function index(Request $request)
    {
        return response()->json(
            $this->service->getAllCandidates(
                $request->query('q'),
                $request->query('name'),
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Recruiter/Candidates/Create',[
            'candidate' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
