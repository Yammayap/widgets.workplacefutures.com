<?php

namespace App\View\Components\SpaceCalculator\Outputs;

use App\Services\SpaceCalculator\OutputAreaType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class AreaTypes extends Component
{
    /**
     * Create a new component instance.
     *
     * @param Collection<int, OutputAreaType> $areaTypes
     */
    public function __construct(public readonly Collection $areaTypes)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.space-calculator.outputs.area-types');
    }
}
