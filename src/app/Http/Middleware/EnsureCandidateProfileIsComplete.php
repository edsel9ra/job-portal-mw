<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCandidateProfileIsComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        if (!$user->isCandidato()) {
            return $next($request);
        }

        $candidate = $user->candidate;

        $isIncomplete = !$candidate
            || empty($candidate->document_type)
            || empty($candidate->document_number)
            || empty($candidate->phone)
            || empty($candidate->birth_date)
            || empty($candidate->city);

        if ($isIncomplete) {
            return redirect()->route('candidato.profile.create');
        }

        return $next($request);
    }
}