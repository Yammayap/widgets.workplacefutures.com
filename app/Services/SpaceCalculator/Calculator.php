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
        return new Output();
    }
}
