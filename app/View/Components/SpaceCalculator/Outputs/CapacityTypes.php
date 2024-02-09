<?php

namespace App\View\Components\SpaceCalculator\Outputs;

use App\Services\SpaceCalculator\OutputCapacityType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class CapacityTypes extends Component
{
    /**
     * Create a new component instance.
     *
     * @param Collection<int,OutputCapacityType> $capacityTypes
     */
    public function __construct(public readonly Collection $capacityTypes)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.space-calculator.outputs.capacity-types');
    }
}
