<?php

namespace App\Services\SpaceCalculator;

class Calculator
{
   /** @phpstan-ignore-next-line */ // todo: set up config vars later and remove phpstan comment
    public function __construct(private readonly Config $config)
    {
        //
    }
}
