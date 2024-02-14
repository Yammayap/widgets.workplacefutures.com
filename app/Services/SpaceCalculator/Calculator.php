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
            ->map(function (Asset $asset) {
                return new AssetCalculation(
                    seatsOrUnitsPerHundred: 0,
                    focusAdjuster: 0,
                    adjustedSeatsOrUnitsPerHundred: 0,
                    populationOverThreshold: false,
                    nominalSeatsOrUnitsCount: 0,
                    impliedUnitCount: 0,
                    roundedUnits: 0,
                    quantity: 0,
                    adjustedSpaceTight: 0,
                    adjustedSpaceAverage: 0,
                    adjustedSpaceSpacious: 0,
                    longDwellWorkstationCapacity: 0,
                    shortDwellWorkstationCapacity: 0,
                    focusSpaceCapacity: 0,
                    breakoutCapacity: 0,
                    recreationCapacity: 0,
                    teamMeetingCapacity: 0,
                    frontOfHouseMeetingCapacity: 0,
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
