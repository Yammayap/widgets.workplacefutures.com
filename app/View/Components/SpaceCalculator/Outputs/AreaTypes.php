<?php

namespace App\View\Components\SpaceCalculator\Outputs;

use App\Services\SpaceCalculator\OutputAreaType;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class AreaTypes extends Component
{
    /**
     * @param Collection<int, OutputAreaType> $areaTypes
     */
    public function __construct(public readonly Collection $areaTypes)
    {
        //
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): View
    {
        return view('components.space-calculator.outputs.area-types');
    }
}
