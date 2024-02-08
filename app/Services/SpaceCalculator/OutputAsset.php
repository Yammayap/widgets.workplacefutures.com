<?php

namespace App\Services\SpaceCalculator;

use App\Enums\Widgets\SpaceCalculator\Asset;

class OutputAsset
{
    /**
     * @param Asset $asset
     * @param int $quantity
     */
    public function __construct(
        public readonly Asset $asset,
        public readonly int $quantity,
    ) {
        //
    }
}
