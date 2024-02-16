<?php

namespace App\Http\Controllers\Web\SpaceCalculator;

use App\Actions\Enquiries\CreateAction as CreateEnquiryAction;
use App\Actions\SpaceCalculatorInputs\CreateAction as CreateSpaceCalculatorInputAction;
use App\Enums\Widget;
use App\Enums\Widgets\SpaceCalculator\Collaboration;
use App\Enums\Widgets\SpaceCalculator\HybridWorking;
use App\Enums\Widgets\SpaceCalculator\Mobility;
use App\Enums\Widgets\SpaceCalculator\Workstyle;
use App\Http\Controllers\WebController;
use App\Http\Requests\Web\SpaceCalculator\Inputs\PostIndexRequest;
use App\Services\TenantManager\TenantManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class InputsController extends WebController
{
    /**
     * @param TenantManager $tenantManager
     */
    public function __construct(private readonly TenantManager $tenantManager)
    {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function getIndex(): View
    {
        $this->metaTitle('Space Calculator Inputs');

        return view('web.space-calculator.inputs', [
            //
        ]);
    }

    /**
     * @param PostIndexRequest $request
     * @return RedirectResponse
     */
    public function postIndex(PostIndexRequest $request): RedirectResponse
    {
        $enquiry = CreateEnquiryAction::run(
            $this->tenantManager->getCurrentTenant(),
            Widget::SPACE_CALCULATOR,
            Auth::user(),
        );

        $input = CreateSpaceCalculatorInputAction::run(
            $enquiry,
            Workstyle::from($request->input('workstyle')),
            $request->integer('total_people'),
            $request->integer('growth_percentage'),
            $request->integer('desk_percentage'),
            HybridWorking::from($request->input('hybrid_working')),
            Mobility::from($request->input('mobility')),
            Collaboration::from($request->input('collaboration')),
        );

        // todo: discuss - what should we do if this is already set?
        // (user may have pressed back button and submitted again) Or just reset it?
        Session::put(config('widgets.space-calculator.input-session-key'), $input->uuid);

        return redirect()->route('web.space-calculator.outputs.index', $input);
    }
}
