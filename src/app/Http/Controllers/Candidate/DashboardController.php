<?php
namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Resume;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();
        $candidate = $user->candidate;

        $resume = Resume::query()
            ->where('candidate_id', $candidate->id)
            ->select('id')
            ->first();

        $aplicaciones = Application::query()
            ->where('candidate_id', $candidate->id)
            ->count();

        return Inertia::render('Candidate/Dashboard', [
            'aplicaciones' => $aplicaciones,
            'tieneCurriculum' => (bool) $resume,
            'resumeId' => $resume?->id,
        ]);
    }
}
