<?php

namespace App\Services\SpaceCalculator;

use App\Enums\Widgets\SpaceCalculator\CapacityType;

readonly class OutputCapacityType
{
    /**
     * @param CapacityType $capacityType
     * @param int $quantity
     */
    public function __construct(
        public CapacityType $capacityType,
        public int $quantity,
    ) {
        //
    }
}
