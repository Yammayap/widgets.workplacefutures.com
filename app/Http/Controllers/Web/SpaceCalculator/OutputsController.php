<?php

namespace App\Http\Controllers\Web\SpaceCalculator;

use App\Actions\Enquiries\AttachToUserAction;
use App\Actions\MagicLinks\SendAction;
use App\Actions\Users\CreateAction;
use App\Http\Controllers\WebController;
use App\Http\Requests\Web\SpaceCalculator\Summary\PostIndexRequest;
use App\Models\SpaceCalculatorInput;
use App\Models\User;
use App\Notifications\SummaryNotification;
use App\Services\SpaceCalculator\Calculator;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OutputsController extends WebController
{
    /**
     * @param Calculator $calculator
     * @param SpaceCalculatorInput $spaceCalculatorInput
     * @return View
     */
    public function getIndex(Calculator $calculator, SpaceCalculatorInput $spaceCalculatorInput): View
    {
        $this->metaTitle('Space Calculator Summary of Results');

        return view('web.space-calculator.outputs', [
            'outputs' => $calculator->calculate($spaceCalculatorInput->transformToCalculatorInputs()),
            'inputs' => $spaceCalculatorInput,
            'user' => $spaceCalculatorInput->enquiry->user,
        ]);
    }

    /**
     * @param PostIndexRequest $request
     * @param SpaceCalculatorInput $spaceCalculatorInput
     * @return RedirectResponse
     */
    public function postIndex(
        PostIndexRequest $request,
        SpaceCalculatorInput $spaceCalculatorInput
    ): RedirectResponse {

        /**
         * @var User|null $user
         */
        $user = User::query()->where('email', $request->input('email'))->first();

        if ($user && $user->has_completed_profile) {
            // todo: This intended route is just a placeholder, it will likely change
            SendAction::run(
                $user,
                $request->ip(),
                route('web.space-calculator.outputs.detailed', $spaceCalculatorInput)
            );
            $request->session()->flash('auth-sent-user', $user);
            return redirect(route('web.auth.sent'));
        }

        if (!$user) {
            $user = CreateAction::run($request->input('email'));
        }

        AttachToUserAction::run($spaceCalculatorInput->enquiry, $user);

        $user->notify(new SummaryNotification($spaceCalculatorInput->enquiry));

        return redirect(route('web.space-calculator.outputs.index', $spaceCalculatorInput));
    }

    public function postFullDetails(): RedirectResponse
    {
        dd('in post full details');
    }

    /**
     * @param SpaceCalculatorInput $spaceCalculatorInput
     * @return View
     */
    public function getDetailed(SpaceCalculatorInput $spaceCalculatorInput): View
    {
        dd('placeholder route - will change');
    }
}
