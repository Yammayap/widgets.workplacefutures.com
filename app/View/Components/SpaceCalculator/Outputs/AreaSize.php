<?php

namespace App\View\Components\SpaceCalculator\Outputs;

use App\Services\SpaceCalculator\OutputAreaSize;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AreaSize extends Component
{
    /**
     * @param \App\Services\SpaceCalculator\OutputAreaSize $areaSize
     */
    public function __construct(public readonly OutputAreaSize $areaSize)
    {
        //
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): View
    {
        return view('components.space-calculator.outputs.area-size');
    }
}
