<?php

namespace App\Services\SpaceCalculator;

class OutputAreaSize
{
    /**
     * @param int $tightSqFt
     * @param int $tightSqM
     * @param int $averageSqFt
     * @param int $averageSqM
     * @param int $spaciousSqFt
     * @param int $spaciousSqM
     */
    public function __construct(
        public readonly int $tightSqFt,
        public readonly int $tightSqM,
        public readonly int $averageSqFt,
        public readonly int $averageSqM,
        public readonly int $spaciousSqFt,
        public readonly int $spaciousSqM,
    ) {
        //
    }
}
