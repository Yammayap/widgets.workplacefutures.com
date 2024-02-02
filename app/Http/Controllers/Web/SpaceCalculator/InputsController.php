<?php

namespace App\Http\Controllers\Web\SpaceCalculator;

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
     * @return RedirectResponse
     */
    public function postIndex(PostSpaceCalculatorInputsRequest $request): RedirectResponse
    {
        dd('in the post function', $request->all());
    }
}
