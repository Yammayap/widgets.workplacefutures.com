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
        public int $tightSqFt,
        public int $tightSqM,
        public int $averageSqFt,
        public int $averageSqM,
        public int $spaciousSqFt,
        public int $spaciousSqM,
    ) {
        //
    }
}
