<?php

namespace App\Http\Controllers\Web\SpaceCalculator;

use App\Actions\SpaceCalculator\CreateAndGetEnquiryAction;
use App\Actions\SpaceCalculator\CreateInputAction;
use App\Enums\Widgets\SpaceCalculator\Collaboration;
use App\Enums\Widgets\SpaceCalculator\HybridWorking;
use App\Enums\Widgets\SpaceCalculator\Mobility;
use App\Enums\Widgets\SpaceCalculator\Workstyle;
use App\Http\Controllers\WebController;
use App\Http\Requests\Web\SpaceCalculator\PostSpaceCalculatorInputsRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InputsController extends WebController
{
    /**
     * @return View
     */
    public function getIndex(): View
    {
        // todo: discuss meta title - probably defer, this is ok for now but doesn't seem like a final title
        $this->metaTitle('Space Calculator Inputs');

        return view('web.space-calculator.inputs', [
            //
        ]);
    }

    /**
     * @param PostSpaceCalculatorInputsRequest $request
     * @return RedirectResponse
     */
    public function postIndex(PostSpaceCalculatorInputsRequest $request): RedirectResponse
    {
        $enquiry = CreateAndGetEnquiryAction::run();

        CreateInputAction::run(
            // todo: is it better to pass in enums here, or pass in strings and run "from()" functions in the action?
            Workstyle::from($request->input('workstyle')),
            $request->input('total_people'),
            $request->input('growth_percentage'),
            $request->input('desk_percentage'),
            HybridWorking::from($request->input('hybrid_working')),
            Mobility::from($request->input('mobility')),
            Collaboration::from($request->input('collaboration')),
            $enquiry,
        );

        // todo: change redirect when ready
        return redirect()->route('web.space-calculator.index');
    }
}
