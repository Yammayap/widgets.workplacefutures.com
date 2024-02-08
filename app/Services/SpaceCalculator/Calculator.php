<?php

namespace App\Services\SpaceCalculator;

class Calculator
{
   /** @phpstan-ignore-next-line */ // todo: set up config vars later and remove phpstan comment
    public function __construct(private readonly Config $config)
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

        return new Output(
            areaSize: $areaSize,
        );
    }
}
