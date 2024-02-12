<?php

namespace App\View\Components\SpaceCalculator\Outputs;

use App\Services\SpaceCalculator\OutputAsset;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Assets extends Component
{
    /**
     * @param Collection<int, OutputAsset> $assets
     */
    public function __construct(public readonly Collection $assets)
    {
        //
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): View
    {
        return view('components.space-calculator.outputs.assets');
    }
}
