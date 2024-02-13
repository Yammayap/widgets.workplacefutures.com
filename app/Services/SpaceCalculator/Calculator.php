<?php

namespace App\Services\SpaceCalculator;

use Illuminate\Support\Arr;
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
        // step one: calculations here - workstations sheet

        // NOTE: percentages as integers - so 36% in the spreadsheet - would be 0.36 here

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
