<?php

namespace App\Http\Middleware;

use App\Models\SpaceCalculatorInput;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class GuardSpaceCalculatorSummaryOutput
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * @var SpaceCalculatorInput $spaceCalculatorInput
         */
        $spaceCalculatorInput = $request->route()?->parameter('spaceCalculatorInput');

        if (Auth::check()) {
            return redirect(route('web.space-calculator.outputs.detailed', $spaceCalculatorInput));
        }

        if (!Session::has(config('widgets.space-calculator.input-session-key'))) {
            return redirect(route('web.space-calculator.index'));
        }

        if (Session::get(config('widgets.space-calculator.input-session-key')) !== $spaceCalculatorInput->uuid) {
            return redirect(route('web.space-calculator.index'));
        }

        return $next($request);
    }
}
