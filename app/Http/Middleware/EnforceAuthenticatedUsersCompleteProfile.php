<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
        if (
            // todo: discuss - better way to handle this?
            Auth::check()
            && Auth::user()
            && !Auth::user()->has_completed_profile
            && !in_array(
                Route::currentRouteName(),
                ['web.profile.index', 'web.profile.index.post']
            )
        ) {
            return redirect(route('web.profile.index'));
        }

        return $next($request);
    }
}
