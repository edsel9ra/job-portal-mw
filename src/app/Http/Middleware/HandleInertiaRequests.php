<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Resume;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [

            'auth' => [
                'user' => $request->user() ? [
                    ...$request->user()->toArray(),
                    'isReclutador' => $request->user()->isReclutador(),
                    'isCandidato' => $request->user()->isCandidato(),
                    'candidate' => $request->user()->candidate ? [
                        'id' => $request->user()->candidate->id,
                        'photo' => $request->user()->candidate->photo,
                        'document_type' => $request->user()->candidate->document_type,
                        'document_number' => $request->user()->candidate->document_number,
                        'phone' => $request->user()->candidate->phone,
                        'birth_date' => $request->user()->candidate->birth_date,
                        'city' => $request->user()->candidate->city,
                    ] : null,
                ] : null,
            ],

            'candidate' => function () use ($request) {
                $user = $request->user();

                if (!$user || !$user->candidate)
                    return null;

                $resumeId = Resume::where('candidate_id', $user->candidate->id)->value('id');

                return [
                    'resumeId' => $resumeId,
                    'hasResume' => (bool) $resumeId,
                ];
            },

            'stats' => function () use ($request) {
                $user = $request->user();

                if (!$user)
                    return null;

                if ($user->isCandidato() && $user->candidate) {
                    return [
                        'aplicacionesPendientes' => Application::where('candidate_id', $user->candidate->id)
                            ->aplicado()   // ← scope del modelo
                            ->count(),
                    ];
                }

                if ($user->isReclutador()) {
                    return [
                        'aplicacionesNuevas' => Application::whereHas('job', fn($q) => $q->where('user_id', $user->id))
                            ->aplicado()   // ← scope del modelo
                            ->count(),
                    ];
                }

                return null;
            },

            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
            ],
        ]);
    }
}
