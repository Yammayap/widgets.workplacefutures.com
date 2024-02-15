<?php

namespace App\Services\SpaceCalculator;

use App\Enums\Widgets\SpaceCalculator\AreaType;
use App\Enums\Widgets\SpaceCalculator\Asset;
use App\Enums\Widgets\SpaceCalculator\CapacityType;
use App\Enums\Widgets\SpaceCalculator\WorkstationType;
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
                    areaType: $asset->areaType(),
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

        // Net areas (sm) - done for adjusted space calculations and capacity by type calculations

        // todo: discuss best way to format this data
        $netAreaTotals = collect();
        $netAreaTotals['adjusted-space'] = collect();
        $netAreaTotals['capacity-by-type'] = collect();

        $netAreaTotals['adjusted-space']['tight'] = $assetCalculations->sum('adjustedSpaceTight');
        $netAreaTotals['adjusted-space']['average'] = $assetCalculations->sum('adjustedSpaceAverage');
        $netAreaTotals['adjusted-space']['spacious'] = $assetCalculations->sum('adjustedSpaceSpacious');

        $netAreaTotals['capacity-by-type'][CapacityType::LONG_DWELL_WORKSTATION->value] = $assetCalculations
            ->sum('longDwellWorkstationCapacity');
        $netAreaTotals['capacity-by-type'][CapacityType::SHORT_DWELL_WORKSTATION->value] = $assetCalculations
            ->sum('shortDwellWorkstationCapacity');
        $netAreaTotals['capacity-by-type'][CapacityType::FOCUS_SPACE->value] = $assetCalculations
            ->sum('focusSpaceCapacity');
        $netAreaTotals['capacity-by-type'][CapacityType::BREAKOUT->value] = $assetCalculations
            ->sum('breakoutCapacity');
        $netAreaTotals['capacity-by-type'][CapacityType::RECREATION->value] = $assetCalculations
            ->sum('recreationCapacity');
        $netAreaTotals['capacity-by-type'][CapacityType::TEAM_MEETING->value] = $assetCalculations
            ->sum('teamMeetingCapacity');
        $netAreaTotals['capacity-by-type'][CapacityType::FRONT_OF_HOUSE->value] = $assetCalculations
            ->sum('frontOfHouseMeetingCapacity');

        // step three: calculations here - area calculations sheet
        /* Note: These are used for 2 outputs...
         * 1. The square foot text in the pink box
         * 2. The space/second pie chart - looks like it uses the "tight" column
         */

        // todo: discuss best way to format this data
        $spaceAmounts = collect();
        $spaceAmounts['workstation'] = collect();
        $spaceAmounts['focus'] = collect();
        $spaceAmounts['collaboration'] = collect();
        $spaceAmounts['congregation'] = collect();
        $spaceAmounts['front-of-house'] = collect();
        $spaceAmounts['facilities'] = collect();

        $spaceAmounts['workstation']['tight'] = $allocationsTightTotal;
        $spaceAmounts['workstation']['average'] = $allocationsAverageTotal;
        $spaceAmounts['workstation']['spacious'] = $allocationsSpaciousTotal;

        $focusAssets = $assetCalculations->where('areaType', AreaType::FOCUS);
        $spaceAmounts['focus']['tight'] = $focusAssets->sum('adjustedSpaceTight');
        $spaceAmounts['focus']['average'] = $focusAssets->sum('adjustedSpaceAverage');
        $spaceAmounts['focus']['spacious'] = $focusAssets->sum('adjustedSpaceSpacious');

        $collaborationAssets = $assetCalculations->where('areaType', AreaType::COLLABORATION);
        $spaceAmounts['collaboration']['tight'] = $collaborationAssets->sum('adjustedSpaceTight');
        $spaceAmounts['collaboration']['average'] = $collaborationAssets->sum('adjustedSpaceAverage');
        $spaceAmounts['collaboration']['spacious'] = $collaborationAssets->sum('adjustedSpaceSpacious');

        $congregationAssets = $assetCalculations->where('areaType', AreaType::CONGREGATION_SPACE);
        $spaceAmounts['congregation']['tight'] = $congregationAssets->sum('adjustedSpaceTight');
        $spaceAmounts['congregation']['average'] = $congregationAssets->sum('adjustedSpaceAverage');
        $spaceAmounts['congregation']['spacious'] = $congregationAssets->sum('adjustedSpaceSpacious');

        $frontOfHouseAssets = $assetCalculations->where('areaType', AreaType::FRONT_OF_HOUSE);
        $spaceAmounts['front-of-house']['tight'] = $frontOfHouseAssets->sum('adjustedSpaceTight');
        $spaceAmounts['front-of-house']['average'] = $frontOfHouseAssets->sum('adjustedSpaceAverage');
        $spaceAmounts['front-of-house']['spacious'] = $frontOfHouseAssets->sum('adjustedSpaceSpacious');

        $facilitiesAssets = $assetCalculations->where('areaType', AreaType::FACILITIES);
        $spaceAmounts['facilities']['tight'] = $facilitiesAssets->sum('adjustedSpaceTight');
        $spaceAmounts['facilities']['average'] = $facilitiesAssets->sum('adjustedSpaceAverage');
        $spaceAmounts['facilities']['spacious'] = $facilitiesAssets->sum('adjustedSpaceSpacious');

        $netAreaAllocations = collect();
        $netAreaAllocations['tight'] = $spaceAmounts->sum('tight');
        $netAreaAllocations['average'] = $spaceAmounts->sum('average');
        $netAreaAllocations['spacious'] = $spaceAmounts->sum('spacious');

        $tightSpaceGrossSmPercentage = Percentage::of(
            Arr::get($this->config->circulationAllowances, 'tight'),
            $netAreaAllocations['tight']
        );
        $tightSpaceGrossSmAmount = $netAreaAllocations['tight'] + $tightSpaceGrossSmPercentage;
        $tightSquareFootAmount = round((($tightSpaceGrossSmAmount * 10.76) / 100)) * 100;

        $averageSpaceGrossSmPercentage = Percentage::of(
            Arr::get($this->config->circulationAllowances, 'average'),
            $netAreaAllocations['average']
        );
        $averageSpaceGrossSmAmount = $netAreaAllocations['average'] + $averageSpaceGrossSmPercentage;
        $averageSquareFootAmount = round((($averageSpaceGrossSmAmount * 10.76) / 100)) * 100;

        $spaciousSpaceGrossSmPercentage = Percentage::of(
            Arr::get($this->config->circulationAllowances, 'spacious'),
            $netAreaAllocations['spacious']
        );
        $spaciousSpaceGrossSmAmount = $netAreaAllocations['spacious'] + $spaciousSpaceGrossSmPercentage;
        $spaciousSquareFootAmount = round((($spaciousSpaceGrossSmAmount * 10.76) / 100)) * 100;

        // step four: calculations here - capacity calculations sheet

        // todo: discuss tidy up - possible DTO
        $capacityAllocations = collect();
        $capacityAllocations[CapacityType::LONG_DWELL_WORKSTATION->value] = $netAreaTotals['capacity-by-type']
            [CapacityType::LONG_DWELL_WORKSTATION->value] + $privateOffices + $openPlanDesks;
        $capacityAllocations[CapacityType::SHORT_DWELL_WORKSTATION->value] = $openPlanTouchdownSpaces + $netAreaTotals
            ['capacity-by-type'][CapacityType::SHORT_DWELL_WORKSTATION->value];
        $capacityAllocations[CapacityType::FOCUS_SPACE->value] = $netAreaTotals['capacity-by-type']
        [CapacityType::FOCUS_SPACE->value];
        $capacityAllocations[CapacityType::BREAKOUT->value] = $netAreaTotals['capacity-by-type']
        [CapacityType::BREAKOUT->value];
        $capacityAllocations[CapacityType::RECREATION->value] = $netAreaTotals['capacity-by-type']
        [CapacityType::RECREATION->value];
        $capacityAllocations[CapacityType::TEAM_MEETING->value] = $netAreaTotals['capacity-by-type']
        [CapacityType::TEAM_MEETING->value];
        $capacityAllocations[CapacityType::FRONT_OF_HOUSE->value] = $netAreaTotals['capacity-by-type']
        [CapacityType::FRONT_OF_HOUSE->value];
        $capacityAllocationsTotal = $capacityAllocations->sum();

        // end of calculations - outputs returned below

        // todo: potentially tidy up later
        $areaSize = new OutputAreaSize(
            (int)$tightSquareFootAmount,
            (int)round($tightSpaceGrossSmAmount),
            (int)$averageSquareFootAmount,
            (int)round($averageSpaceGrossSmAmount),
            (int)$spaciousSquareFootAmount,
            (int)round($spaciousSpaceGrossSmAmount),
        );
        $capacityTypes = collect([
            new OutputCapacityType(
                CapacityType::LONG_DWELL_WORKSTATION,
                $capacityAllocations[CapacityType::LONG_DWELL_WORKSTATION->value]
            ),
            new OutputCapacityType(
                CapacityType::SHORT_DWELL_WORKSTATION,
                $capacityAllocations[CapacityType::SHORT_DWELL_WORKSTATION->value]
            ),
            new OutputCapacityType(
                CapacityType::FOCUS_SPACE,
                $capacityAllocations[CapacityType::FOCUS_SPACE->value]
            ),
            new OutputCapacityType(
                CapacityType::BREAKOUT,
                $capacityAllocations[CapacityType::BREAKOUT->value]
            ),
            new OutputCapacityType(
                CapacityType::RECREATION,
                $capacityAllocations[CapacityType::RECREATION->value]
            ),
            new OutputCapacityType(
                CapacityType::TEAM_MEETING,
                $capacityAllocations[CapacityType::TEAM_MEETING->value]
            ),
            new OutputCapacityType(
                CapacityType::FRONT_OF_HOUSE,
                $capacityAllocations[CapacityType::FRONT_OF_HOUSE->value]
            ),
        ]);
        // todo: We may need to ask them about this but looks like the 2nd pie chart is the tight space data
        $areaTypes = collect([
            new OutputAreaType( // todo: consider how this works and $isEnum var when making the pie chart
                'workstations',
                $spaceAmounts['workstation']['tight'],
                false,
            ),
            new OutputAreaType(
                AreaType::FOCUS,
                $spaceAmounts['focus']['tight'],
                true,
            ),
            new OutputAreaType(
                AreaType::COLLABORATION,
                $spaceAmounts['collaboration']['tight'],
                true,
            ),
            new OutputAreaType(
                AreaType::CONGREGATION_SPACE,
                $spaceAmounts['congregation']['tight'],
                true,
            ),
            new OutputAreaType(
                AreaType::FRONT_OF_HOUSE,
                $spaceAmounts['front-of-house']['tight'],
                true,
            ),
            new OutputAreaType(
                AreaType::FACILITIES,
                $spaceAmounts['facilities']['tight'],
                true,
            ),
        ]);

        $assets = collect();

        if ($privateOffices != 0) {
            $assets[WorkstationType::PRIVATE_OFFICES->value] = new OutputAsset(
                WorkstationType::PRIVATE_OFFICES,
                (int) round($privateOffices),
            );
        }
        if ($openPlanDesks != 0) {
            $assets[WorkstationType::OPEN_PLAN_DESKS->value] = new OutputAsset(
                WorkstationType::OPEN_PLAN_DESKS,
                (int) round($openPlanDesks),
            );
        }
        if ($openPlanTouchdownSpaces != 0) {
            $assets[WorkstationType::OPEN_PLAN_TOUCHDOWN_DESKS->value] = new OutputAsset(
                WorkstationType::OPEN_PLAN_TOUCHDOWN_DESKS,
                (int) round($openPlanTouchdownSpaces),
            );
        }
        $assets = $assets->merge(
            $assetCalculations->where('quantity', '!=', 0)
                ->map(function (AssetCalculation $assetCalculation, string $key): OutputAsset {
                    /**
                     * @var int $quantity
                     */
                    $quantity = $assetCalculation->quantity;
                    return new OutputAsset(
                        Asset::from($key),
                        $quantity,
                    );
                })
        );

        return new Output(
            areaSize: $areaSize,
            assets: $assets,
            capacityTypes: $capacityTypes,
            areaTypes: $areaTypes,
        );
    }
}
