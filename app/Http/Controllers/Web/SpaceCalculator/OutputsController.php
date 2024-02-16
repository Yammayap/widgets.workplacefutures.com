<?php

namespace App\Http\Controllers\Web\SpaceCalculator;

use App\Http\Controllers\WebController;
use App\Http\Requests\Web\SpaceCalculator\Summary\PostIndexRequest;
use App\Models\SpaceCalculatorInput;
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
        dd('here', $request->all());
    }
}
