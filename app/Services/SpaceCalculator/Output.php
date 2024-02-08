<?php

namespace App\Services\SpaceCalculator;

class Output
{
    /**
     * @param OutputAreaSize $areaSize
     */
    public function __construct(
        public readonly OutputAreaSize $areaSize,
    ) {
        //
    }
}
