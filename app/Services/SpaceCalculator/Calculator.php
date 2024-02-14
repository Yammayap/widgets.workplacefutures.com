<?php

namespace App\Services\SpaceCalculator;

use App\Enums\Widgets\SpaceCalculator\Asset;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Mattiasgeniar\Percentage\Percentage;

class Calculator
{
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
        // NOTE: percentages as integers - so 36% in the spreadsheet - would be 0.36 here

        // step one: calculations here - workstations sheet

        $peopleWorkingPlusGrowth = round(
            $inputs->totalPeople + Percentage::of($inputs->growthPercentage, $inputs->totalPeople)
        );

        $percentageToAccommodate = (Arr::get(
            Arr::get(
                $this->config->workstyleParameters,
                $inputs->workstyle->value
            ),
            'hybrid-working.' . $inputs->hybridWorking->value
        )) / 100;

        $undiversifiedAllocation = round(Percentage::of($inputs->deskPercentage, $peopleWorkingPlusGrowth));

        $diversifiedAllocation = round((Percentage::of(
            $percentageToAccommodate,
            $peopleWorkingPlusGrowth - $undiversifiedAllocation
        )) * 100);

        $mobilityAdjuster = (Arr::get($this->config->mobilityAdjusters, $inputs->mobility->value)) / 100;

        $collaborationAdjuster = (Arr::get($this->config->collaborationAdjusters, $inputs->collaboration->value)) / 100;

        $privateOfficeFactor = (Arr::get(
            Arr::get($this->config->workstyleParameters, $inputs->workstyle->value),
            'workstations.private-offices'
        )) / 100;

        $adjustedPrivateOfficeFactor = $privateOfficeFactor * (1 - $collaborationAdjuster);

        $touchdownFactor = (Arr::get(
            Arr::get($this->config->workstyleParameters, $inputs->workstyle->value),
            'workstations.use-of-touchdown'
        )) / 100;

        $undiversifiedOfficeAllocation = round($undiversifiedAllocation * $adjustedPrivateOfficeFactor);

        $undiversifiedDeskAllocation = round($undiversifiedAllocation * (1 - $adjustedPrivateOfficeFactor));

        $diversifiedTouchdownAllocation = round($diversifiedAllocation * $touchdownFactor * (1 + $mobilityAdjuster));

        $diversifiedDeskAllocation = round(
            ($diversifiedAllocation - $diversifiedTouchdownAllocation) * (1 - $privateOfficeFactor)
        );

        $diversifiedOfficeAllocation = round(
            ($diversifiedAllocation - $diversifiedTouchdownAllocation) * $privateOfficeFactor
        );

        $spaceStandardAdjuster = (Arr::get(
            Arr::get($this->config->workstyleParameters, $inputs->workstyle->value),
            'area-adjuster'
        )) / 100;

        // grey box totals
        $privateOffices = $undiversifiedOfficeAllocation + $diversifiedOfficeAllocation;
        $openPlanDesks = $undiversifiedDeskAllocation + $diversifiedDeskAllocation;
        $openPlanTouchdownSpaces = $diversifiedTouchdownAllocation; // this one could be simplified
        $totalOpenPlan = $openPlanDesks + $openPlanTouchdownSpaces;
        $totalWorkstations = $privateOffices + $totalOpenPlan;

        // Adjusted space standards (All multiplied by $spaceStandardAdjuster)
        $ASStandardsTightA = $spaceStandardAdjuster * Arr::get($this->config->rawSpaceStandards, 'tight.0');
        $ASStandardsTightB = $spaceStandardAdjuster * Arr::get($this->config->rawSpaceStandards, 'tight.1');
        $ASStandardsTightC = $spaceStandardAdjuster * Arr::get($this->config->rawSpaceStandards, 'tight.2');
        $ASStandardsAverageA = $spaceStandardAdjuster * Arr::get($this->config->rawSpaceStandards, 'average.0');
        $ASStandardsAverageB = $spaceStandardAdjuster * Arr::get($this->config->rawSpaceStandards, 'average.1');
        $ASStandardsAverageC = $spaceStandardAdjuster * Arr::get($this->config->rawSpaceStandards, 'average.2');
        $ASStandardsSpaciousA = $spaceStandardAdjuster * Arr::get($this->config->rawSpaceStandards, 'spacious.0');
        $ASStandardsSpaciousB = $spaceStandardAdjuster * Arr::get($this->config->rawSpaceStandards, 'spacious.1');
        $ASStandardsSpaciousC = $spaceStandardAdjuster * Arr::get($this->config->rawSpaceStandards, 'spacious.2');

        // Allocations
        $allocationsTightA = $privateOffices * $ASStandardsTightA;
        $allocationsTightB = $openPlanDesks * $ASStandardsTightB;
        $allocationsTightC = $openPlanTouchdownSpaces * $ASStandardsTightC;
        $allocationsTightTotal = $allocationsTightA + $allocationsTightB + $allocationsTightC;
        $allocationsAverageA = $privateOffices * $ASStandardsAverageA;
        $allocationsAverageB = $openPlanDesks * $ASStandardsAverageB;
        $allocationsAverageC = $openPlanTouchdownSpaces * $ASStandardsAverageC;
        $allocationsAverageTotal = $allocationsAverageA + $allocationsAverageB + $allocationsAverageC;
        $allocationsSpaciousA = $privateOffices * $ASStandardsSpaciousA;
        $allocationsSpaciousB = $openPlanDesks * $ASStandardsSpaciousB;
        $allocationsSpaciousC = $openPlanTouchdownSpaces * $ASStandardsSpaciousC;
        $allocationsSpaciousTotal = $allocationsSpaciousA + $allocationsSpaciousB + $allocationsSpaciousC;

        // step two: calculations here - assets sheet

        $assetCalculations = (new Collection(Asset::cases()))
            ->keyBy(function (Asset $asset) {
                return $asset->value;
            })
            ->map(function (Asset $asset) use (
                $inputs,
                $collaborationAdjuster,
                $totalWorkstations,
                $spaceStandardAdjuster
            ) {

                $seatsOrUnitsPerHundred = Arr::get(
                    Arr::get(
                        Arr::get($this->config->assetParameters, $asset->value),
                        'workstyle-parameters',
                    ),
                    $inputs->workstyle->value,
                );

                // returns either P (plus), M (minus) or null
                $focusAdjusterMethod = Arr::get(
                    Arr::get(
                        Arr::get($this->config->assetParameters, $asset->value),
                        'use-parameters',
                    ),
                    'focus-adjuster',
                );

                $focusAdjuster = $focusAdjusterMethod == 'P' ? 1 + $collaborationAdjuster
                    : ($focusAdjusterMethod == 'M' ? 1 - $collaborationAdjuster
                        : 1);

                $adjustedSeatsOrUnitsPerHundred = $seatsOrUnitsPerHundred * $focusAdjuster;

                $thresholdPopulation = Arr::get(
                    Arr::get(
                        Arr::get($this->config->assetParameters, $asset->value),
                        'use-parameters',
                    ),
                    'threshold-population',
                );
                $populationOverThreshold = $totalWorkstations > $thresholdPopulation;

                $nominalSeatsOrUnitsCount = $adjustedSeatsOrUnitsPerHundred / 100 * $totalWorkstations
                    * $populationOverThreshold;

                $impliedUnitCountUnitMultiple = Arr::get(
                    Arr::get(
                        Arr::get($this->config->assetParameters, $asset->value),
                        'capacity-and-multiples',
                    ),
                    'unit-multiple',
                );
                $impliedUnitCount = $nominalSeatsOrUnitsCount / $impliedUnitCountUnitMultiple;

                // This is either U (up) or D (down)
                $roundedUnitsType = Arr::get(
                    Arr::get(
                        Arr::get($this->config->assetParameters, $asset->value),
                        'use-parameters',
                    ),
                    'rounding',
                );
                $roundedUnits = $roundedUnitsType == 'U' ? (int) ceil($impliedUnitCount)
                    : (int) floor($impliedUnitCount);

                $quantityConfig = Arr::get(
                    Arr::get(
                        Arr::get($this->config->assetParameters, $asset->value),
                        'use-parameters',
                    ),
                    'maximum-quantity',
                );
                $quantity = $quantityConfig == null ? $roundedUnits : (min($roundedUnits, $quantityConfig));

                $adjustedSpaceTightConfig = Arr::get(
                    Arr::get(
                        Arr::get($this->config->assetParameters, $asset->value),
                        'space-standards',
                    ),
                    'tight',
                );
                $adjustedSpaceTight = $quantity * $adjustedSpaceTightConfig * $spaceStandardAdjuster;

                $adjustedSpaceAverageConfig = Arr::get(
                    Arr::get(
                        Arr::get($this->config->assetParameters, $asset->value),
                        'space-standards',
                    ),
                    'average',
                );
                $adjustedSpaceAverage = $quantity * $adjustedSpaceAverageConfig * $spaceStandardAdjuster;

                $adjustedSpaceSpaciousConfig = Arr::get(
                    Arr::get(
                        Arr::get($this->config->assetParameters, $asset->value),
                        'space-standards',
                    ),
                    'spacious',
                );
                $adjustedSpaceSpacious = $quantity * $adjustedSpaceSpaciousConfig * $spaceStandardAdjuster;

                $longDwellWorkstationCapacityConfig = Arr::get(
                    Arr::get(
                        Arr::get($this->config->assetParameters, $asset->value),
                        'capacity-and-multiples',
                    ),
                    'long-dwell-workstation',
                );
                $longDwellWorkstationCapacity = $quantity * $longDwellWorkstationCapacityConfig;

                $shortDwellWorkstationCapacityConfig = Arr::get(
                    Arr::get(
                        Arr::get($this->config->assetParameters, $asset->value),
                        'capacity-and-multiples',
                    ),
                    'short-dwell-workstation',
                );
                $shortDwellWorkstationCapacity = $quantity * $shortDwellWorkstationCapacityConfig;

                $focusSpaceCapacityConfig = Arr::get(
                    Arr::get(
                        Arr::get($this->config->assetParameters, $asset->value),
                        'capacity-and-multiples',
                    ),
                    'focus-space',
                );
                $focusSpaceCapacity = $quantity * $focusSpaceCapacityConfig;

                $breakoutCapacityConfig = Arr::get(
                    Arr::get(
                        Arr::get($this->config->assetParameters, $asset->value),
                        'capacity-and-multiples',
                    ),
                    'breakout',
                );
                $breakoutCapacity = $quantity * $breakoutCapacityConfig;

                $recreationCapacityConfig = Arr::get(
                    Arr::get(
                        Arr::get($this->config->assetParameters, $asset->value),
                        'capacity-and-multiples',
                    ),
                    'recreation',
                );
                $recreationCapacity = $quantity * $recreationCapacityConfig;

                $teamMeetingCapacityConfig = Arr::get(
                    Arr::get(
                        Arr::get($this->config->assetParameters, $asset->value),
                        'capacity-and-multiples',
                    ),
                    'team-meeting',
                );
                $teamMeetingCapacity = $quantity * $teamMeetingCapacityConfig;

                $frontOfHouseMeetingCapacityConfig = Arr::get(
                    Arr::get(
                        Arr::get($this->config->assetParameters, $asset->value),
                        'capacity-and-multiples',
                    ),
                    'front-of-house-meeting',
                );
                $frontOfHouseMeetingCapacity = $quantity * $frontOfHouseMeetingCapacityConfig;

                return new AssetCalculation(
                    seatsOrUnitsPerHundred: $seatsOrUnitsPerHundred,
                    focusAdjuster: $focusAdjuster,
                    adjustedSeatsOrUnitsPerHundred: $adjustedSeatsOrUnitsPerHundred,
                    populationOverThreshold: $populationOverThreshold,
                    nominalSeatsOrUnitsCount: $nominalSeatsOrUnitsCount,
                    impliedUnitCount: $impliedUnitCount,
                    roundedUnits: $roundedUnits,
                    quantity: $quantity,
                    adjustedSpaceTight: $adjustedSpaceTight,
                    adjustedSpaceAverage: $adjustedSpaceAverage,
                    adjustedSpaceSpacious: $adjustedSpaceSpacious,
                    longDwellWorkstationCapacity: $longDwellWorkstationCapacity,
                    shortDwellWorkstationCapacity: $shortDwellWorkstationCapacity,
                    focusSpaceCapacity: $focusSpaceCapacity,
                    breakoutCapacity: $breakoutCapacity,
                    recreationCapacity: $recreationCapacity,
                    teamMeetingCapacity: $teamMeetingCapacity,
                    frontOfHouseMeetingCapacity: $frontOfHouseMeetingCapacity,
                );
            });

        // end of calculations - empty outputs returned below

        $areaSize = new OutputAreaSize(0, 0, 0, 0, 0, 0);
        $assets = collect();
        $capacityTypes = collect();
        $areaTypes = collect();

        return new Output(
            areaSize: $areaSize,
            assets: $assets,
            capacityTypes: $capacityTypes,
            areaTypes: $areaTypes,
        );
    }
}
