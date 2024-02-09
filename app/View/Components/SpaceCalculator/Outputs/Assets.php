<?php

namespace App\View\Components\SpaceCalculator\Outputs;

use App\Services\SpaceCalculator\OutputAsset;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Assets extends Component
{
    /**
     * Create a new component instance.
     *
     * @param Collection<int,OutputAsset> $assets
     */
    public function __construct(public readonly Collection $assets)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.space-calculator.outputs.assets');
    }
}
