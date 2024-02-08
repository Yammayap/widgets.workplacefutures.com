<?php

namespace App\Services\SpaceCalculator;

readonly class Calculator
{
   /** @phpstan-ignore-next-line */ // todo: set up config vars later and remove phpstan comment
    public function __construct(private Config $config)
    {
        //
    }

    /**
     * @param Inputs $inputs
     * @return Output
     */
    public function calculate(Inputs $inputs): Output
    {
        // adding classes with empty results for now for Larastan and tests while we are only doing the structure
        // todo: real calculations!

        $areaSize = new OutputAreaSize(0, 0, 0, 0, 0, 0);
        $assets = collect();
        $capacityTypes = collect();
        $areaTypes = collect();

        return new Output(
            areaSize: $areaSize,
            assets: $assets,
            capacityTypes: $capacityTypes,
            areaTypes: $areaTypes,
        );
    }
}
