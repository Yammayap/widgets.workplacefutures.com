<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class EnsureAuthenticatedUserHasCompletedProfile
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            in_array(Route::currentRouteName(), [
                'web.profile.index',
                'web.profile.index.post',
                'web.auth.sign-out',
                'web.auth.sign-out.post',
            ])
        ) {
            return $next($request);
        }

        if (!$request->user()) {
            return $next($request);
        }

        if ($request->user()->has_completed_profile) {
            return $next($request);
        }

        return redirect(route('web.profile.index'));
    }
}
