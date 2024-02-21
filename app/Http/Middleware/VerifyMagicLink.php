<?php

namespace App\Http\Middleware;

use App\Models\MagicLink;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyMagicLink
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * @var MagicLink|null $magicLink
         */
        $magicLink = $request->route('magicLink');

        if (!$magicLink) {
            return redirect(route('web.home.index'));
        }

        if ($magicLink->expires_at->isPast()) {
            return redirect(route('web.portal'));
        }

        if ($magicLink->authenticated_at != null) {
            return redirect(route('web.portal'));
        }

        if ($request->ip() != $magicLink->ip_requested_from) {
            return redirect(route('web.portal'));
        }

        return $next($request);
    }
}
