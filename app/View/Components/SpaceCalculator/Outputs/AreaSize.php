<?php

namespace App\View\Components\SpaceCalculator\Outputs;

use App\Services\SpaceCalculator\OutputAreaSize;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AreaSize extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public readonly OutputAreaSize $areaSize)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.space-calculator.outputs.area-size');
    }
}
