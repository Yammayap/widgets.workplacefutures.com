<?php

namespace App\Http\Middleware;

use App\Models\SpaceCalculatorInput;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class GuardSpaceCalculatorOutput
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

        if (!Session::has(config('widgets.space-calculator.input-session-key'))) {
            return redirect(route('web.space-calculator.index'));
        }

        /**
         * @var SpaceCalculatorInput $model
         */
        $model = $request->route()?->parameter('spaceCalculatorInput');

        if (
            Session::get(config('widgets.space-calculator.input-session-key')) != $model->uuid
        ) {
            return redirect(route('web.space-calculator.index'));
        }

        return $next($request);
    }
}
