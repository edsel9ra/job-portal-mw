<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function create(): Response
    {
        $user = auth()->user();
        $candidate = $user->candidate;

        return Inertia::render('Candidate/Profile/Form', [
            'candidate' => $candidate ? [
                'document_type' => $candidate->document_type,
                'document_number' => $candidate->document_number,
                'phone' => $candidate->phone,
                'birth_date' => $candidate->birth_date,
                'city' => $candidate->city,
                'photo' => $candidate->photo,
            ] : null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $candidate = $user->candidate;

        $validated = $request->validate([
            'document_type' => ['required', 'in:CC,CE,TI,Pasaporte,PT'],
            'document_number' => [
                'required',
                'string',
                'max:255',
                'unique:candidates,document_number,' . ($candidate?->id ?? 'NULL') . ',id',
            ],
            'phone' => ['required', 'string', 'max:20'],
            'birth_date' => ['required', 'date'],
            'city' => ['required', 'string', 'max:100'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('candidates', 'public');
        } elseif ($candidate) {
            $validated['photo'] = $candidate->photo;
        }

        $validated['user_id'] = $user->id;

        Candidate::updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()
            ->route('candidato.dashboard')
            ->with('success', 'Perfil completado correctamente.');
    }

    public function edit(): Response
    {
        $user = auth()->user();
        $candidate = $user->candidate;

        return Inertia::render('Candidate/Profile/Edit', [
            'candidate' => $candidate ? [
                'id' => $candidate->id,
                'document_type' => $candidate->document_type,
                'document_number' => $candidate->document_number,
                'phone' => $candidate->phone,
                'birth_date' => $candidate->birth_date,
                'city' => $candidate->city,
                'photo' => $candidate->photo,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ] : null,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $candidate = $user->candidate;

        $validated = $request->validate([
            'document_type' => ['required', 'in:CC,CE,TI,Pasaporte,PT'],
            'document_number' => [
                'required',
                'string',
                'max:255',
                'unique:candidates,document_number,' . ($candidate?->id ?? 'NULL') . ',id',
            ],
            'phone' => ['required', 'string', 'max:20'],
            'birth_date' => ['required', 'date'],
            'city' => ['required', 'string', 'max:100'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('candidates', 'public');
        } elseif ($candidate) {
            $validated['photo'] = $candidate->photo;
        }

        $user->candidate()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()
            ->route('candidato.profile.edit')
            ->with('success', 'Perfil actualizado correctamente.');
    }
}