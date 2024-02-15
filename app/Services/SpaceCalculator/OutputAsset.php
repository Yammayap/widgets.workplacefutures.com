<?php

namespace App\Services\SpaceCalculator;

use App\Enums\Widgets\SpaceCalculator\Asset;
use App\Enums\Widgets\SpaceCalculator\WorkstationType;

readonly class OutputAsset
{
    /**
     * @param Asset|WorkstationType $asset
     * @param int $quantity
     */
    public function __construct(
        public Asset|WorkstationType $asset,
        public int $quantity,
    ) {
        //
    }
}
