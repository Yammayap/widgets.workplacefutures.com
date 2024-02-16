<?php

namespace App\Http\Controllers\Web\SpaceCalculator;

use App\Http\Controllers\WebController;
use App\Http\Requests\Web\SpaceCalculator\Summary\PostIndexRequest;
use App\Models\SpaceCalculatorInput;
use App\Models\User;
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
        ]);
    }

    /**
     * @param Calculator $calculator
     * @param PostIndexRequest $request
     * @param SpaceCalculatorInput $spaceCalculatorInput
     * @return RedirectResponse
     */
    public function postIndex(
        Calculator $calculator,
        PostIndexRequest $request,
        SpaceCalculatorInput $spaceCalculatorInput
    ): RedirectResponse {

        $user = User::query()->where('email', $request->input('email'))->first();

        if ($user && $user->has_completed_profile) {
            /*
             * 1. run magic link action
             * 2. return redirect to new /auth/sent page telling user to click link in the email
             */
            dd('WIP 1');
        }

        if (!$user) {
            // create new user here and put into $user var - new action
            dd('WIP 2');
        }

        /*
         * more to do here
         * 1. Update the enquiry (get via inputs) user id - new action
         * 2. Send the user the summary notification
         */

        return redirect(route('web.space-calculator.outputs.index', $spaceCalculatorInput));
    }
}
