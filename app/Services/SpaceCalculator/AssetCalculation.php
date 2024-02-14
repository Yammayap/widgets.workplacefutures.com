<?php

namespace App\Services\SpaceCalculator;

readonly class AssetCalculation
{
    /**
     * @param float $seatsOrUnitsPerHundred
     * @param float $focusAdjuster
     * @param float|null $adjustedSeatsOrUnitsPerHundred
     * @param bool $populationOverThreshold
     * @param float|null $nominalSeatsOrUnitsCount
     * @param float|null $impliedUnitCount
     * @param int $roundedUnits
     * @param int|null $quantity
     * @param float|null $adjustedSpaceTight
     * @param float|null $adjustedSpaceAverage
     * @param float|null $adjustedSpaceSpacious
     * @param int|null $longDwellWorkstationCapacity
     * @param int|null $shortDwellWorkstationCapacity
     * @param int|null $focusSpaceCapacity
     * @param int|null $breakoutCapacity
     * @param int|null $recreationCapacity
     * @param int|null $teamMeetingCapacity
     * @param int|null $frontOfHouseMeetingCapacity
     */
    public function __construct(
        public float $seatsOrUnitsPerHundred,
        public float $focusAdjuster,
        public float|null $adjustedSeatsOrUnitsPerHundred,
        public bool $populationOverThreshold,
        public float|null $nominalSeatsOrUnitsCount,
        public float|null $impliedUnitCount,
        public int $roundedUnits,
        public int|null $quantity,
        public float|null $adjustedSpaceTight,
        public float|null $adjustedSpaceAverage,
        public float|null $adjustedSpaceSpacious,
        public int|null $longDwellWorkstationCapacity,
        public int|null $shortDwellWorkstationCapacity,
        public int|null $focusSpaceCapacity,
        public int|null $breakoutCapacity,
        public int|null $recreationCapacity,
        public int|null $teamMeetingCapacity,
        public int|null $frontOfHouseMeetingCapacity,
    ) {
        // Note: properties are in order of how they appear in the spreadsheet
    }
}
