<?php

namespace App\Services\SpaceCalculator;

use App\Enums\Widgets\SpaceCalculator\CapacityType;

class OutputCapacityType
{
    /**
     * @param CapacityType $capacityType
     * @param int $quantity
     */
    public function __construct(
        public readonly CapacityType $capacityType,
        public readonly int $quantity,
    ) {
        //
    }
}
