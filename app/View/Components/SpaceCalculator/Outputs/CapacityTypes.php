<?php

namespace App\View\Components\SpaceCalculator\Outputs;

use App\Services\SpaceCalculator\OutputCapacityType;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class CapacityTypes extends Component
{
    /**
     * @param Collection<int, OutputCapacityType> $capacityTypes
     */
    public function __construct(public readonly Collection $capacityTypes)
    {
        //
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): View
    {
        return view('components.space-calculator.outputs.capacity-types');
    }
}
