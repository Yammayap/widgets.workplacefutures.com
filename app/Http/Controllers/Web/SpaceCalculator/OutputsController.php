<?php

namespace App\Http\Controllers\Web\SpaceCalculator;

use App\Http\Controllers\WebController;
use App\Models\SpaceCalculatorInput;
use App\Services\SpaceCalculator\Calculator;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class OutputsController extends WebController
{
    public function __construct(private readonly Calculator $calculator)
    {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function getIndex(): View
    {
        $this->metaTitle('Space Calculator Summary of Results');

        /**
         * @var SpaceCalculatorInput $inputModel
         */
        $inputModel = SpaceCalculatorInput::query()
            ->where(
                'uuid',
                Session::get(config('widgets.space-calculator.outputs-summary-session-id-key'))
            )
            ->first();

        return view('web.space-calculator.outputs', [
            'outputs' => $this->calculator->calculate($inputModel->transformToCalculatorInputs()),
            'inputs' => $inputModel,
        ]);
    }
}
