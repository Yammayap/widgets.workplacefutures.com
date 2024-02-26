<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnforceAuthenticatedUsersCompleteProfile
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user() && !Auth::user()->has_completed_profile) {
            return redirect(route('web.profile.index'));
        }

        return $next($request);
    }
}
