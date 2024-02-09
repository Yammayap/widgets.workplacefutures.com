<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SpaceCalculatorOutputsSummaryAuthCheck
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) { // todo: change this the prospect portal route when built
            return redirect(route('web.space-calculator.index'));
        }

        if (!Session::has('space-calculator-inputs-uuid')) {
            // todo: might be good to do Laraflash messages here later
            return redirect(route('web.space-calculator.index'));
        }

        if (Session::get('space-calculator-inputs-uuid') != $request->route()?->parameter('id')) {
            // todo: might be good to do a Laraflash message here later
            return redirect(route('web.space-calculator.index'));
        }

        return $next($request);
    }
}
