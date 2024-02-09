<?php

namespace App\View\Components\SpaceCalculator\Outputs;

use App\Models\SpaceCalculatorInput;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Questions extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public readonly SpaceCalculatorInput $inputs)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.space-calculator.outputs.questions');
    }
}
