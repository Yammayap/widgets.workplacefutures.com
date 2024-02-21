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
         * @var SpaceCalculatorInput $model
         */
        $model = $request->route()?->parameter('spaceCalculatorInput');

        if (!Auth::check()) {
            $user = $model->enquiry->user;

            if ($user && !$user->has_completed_profile) {
                return redirect(route('web.space-calculator.index'));
            }

            if (!Session::has(config('widgets.space-calculator.input-session-key'))) {
                return redirect(route('web.space-calculator.index'));
            }

            if (Session::get(config('widgets.space-calculator.input-session-key')) !== $model->uuid) {
                return redirect(route('web.space-calculator.index'));
            }
        }

        if (Auth::check()) {

            /**
             * @var User $user
             */
            $user = Auth::user();

            if (!$user->has_completed_profile) {
                // todo: discuss - would this link to a profile edit screen perhaps later?
                return redirect(route('web.portal.index'));
            }

            if ($model->enquiry->user_id != $user->id) {
                return redirect(route('web.portal.index'));
            }
        }

        return $next($request);
    }
}
