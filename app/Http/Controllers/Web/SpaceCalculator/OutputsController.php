<?php

namespace App\Http\Controllers\Web\SpaceCalculator;

use App\Actions\Enquiries\AddContactDetailsAction;
use App\Actions\Enquiries\AttachToUserAction;
use App\Actions\MagicLinks\SendAction;
use App\Actions\Users\CreateAction;
use App\Actions\Users\UpdateProfileAction;
use App\Http\Controllers\WebController;
use App\Http\Requests\Web\SpaceCalculator\Summary\PostIndexRequest;
use App\Http\Requests\Web\SpaceCalculator\Summary\PostProfileRequest;
use App\Jobs\Enquiries\TransmitToHubSpotJob;
use App\Models\SpaceCalculatorInput;
use App\Models\User;
use App\Notifications\SummaryNotification;
use App\Services\SpaceCalculator\Calculator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Propaganistas\LaravelPhone\PhoneNumber;

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
            AttachToUserAction::run($spaceCalculatorInput->enquiry, $user);
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

    /**
     * @param PostProfileRequest $request
     * @param SpaceCalculatorInput $spaceCalculatorInput
     *
     * @return RedirectResponse
     */
    public function postProfile(
        PostProfileRequest $request,
        SpaceCalculatorInput $spaceCalculatorInput
    ): RedirectResponse {

        $enquiry = $spaceCalculatorInput->enquiry;

        if ($request->filled('phone')) {
            $phone = new PhoneNumber(
                $request->input('phone'),
                Str::startsWith($request->input('phone'), '+') ? null : 'GB'
            );
        } else {
            $phone = null;
        }

        UpdateProfileAction::run(
            $enquiry->user,
            $request->input('first_name'),
            $request->input('last_name'),
            $request->input('company_name'),
            $phone,
            $request->boolean('marketing_opt_in'),
        );

        AddContactDetailsAction::run(
            $enquiry,
            $request->input('message'),
            $request->boolean('can_contact'),
        );

        TransmitToHubSpotJob::dispatch($enquiry);

        return redirect(route('web.space-calculator.outputs.detailed', $spaceCalculatorInput));
    }

    /**
     * @param Calculator $calculator
     * @param SpaceCalculatorInput $spaceCalculatorInput
     * @return View
     */
    public function getDetailed(Calculator $calculator, SpaceCalculatorInput $spaceCalculatorInput): View
    {
        $this->metaTitle('Space Calculator Detailed Results');

        return view('web.space-calculator.detailed-results', [
            'outputs' => $calculator->calculate($spaceCalculatorInput->transformToCalculatorInputs()),
            'inputs' => $spaceCalculatorInput,
            'user' => $spaceCalculatorInput->enquiry->user,
        ]);
    }

    public function postDetailed(SpaceCalculatorInput $spaceCalculatorInput): RedirectResponse
    {
 // needs request class
        dd('in post detailed');
    }
}
