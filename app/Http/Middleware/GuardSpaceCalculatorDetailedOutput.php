<?php

namespace App\Http\Middleware;

use App\Models\SpaceCalculatorInput;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class GuardSpaceCalculatorDetailedOutput
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

        if (!Auth::check()) {
            $user = $spaceCalculatorInput->enquiry->user;

            if (!$user) {
                return redirect(route('web.space-calculator.outputs.index', $spaceCalculatorInput));
            }

            if (!$user->has_completed_profile) {
                return redirect(route('web.space-calculator.outputs.index', $spaceCalculatorInput));
            }

            if (!Session::has(config('widgets.space-calculator.input-session-key'))) {
                return redirect(route('web.space-calculator.index'));
            }

            if (Session::get(config('widgets.space-calculator.input-session-key')) !== $spaceCalculatorInput->uuid) {
                return redirect(route('web.space-calculator.index'));
            }
        }

        if (Auth::check()) {

            /**
             * @var User $user
             */
            $user = Auth::user();

            if (!$user->has_completed_profile) {
                return redirect(route('web.portal.index'));
            }

            if (!$spaceCalculatorInput->enquiry->user?->is($user)) {
                return redirect(route('web.portal.index'));
            }
        }

        return $next($request);
    }
}
