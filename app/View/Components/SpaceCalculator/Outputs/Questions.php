<?php

namespace App\View\Components\SpaceCalculator\Outputs;

use App\Models\SpaceCalculatorInput;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Questions extends Component
{
    /**
     * @param \App\Models\SpaceCalculatorInput $inputs
     */
    public function __construct(public readonly SpaceCalculatorInput $inputs)
    {
        //
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): View
    {
        return view('components.space-calculator.outputs.questions');
    }
}
