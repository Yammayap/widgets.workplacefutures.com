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

        $peopleWorkingPlusGrowth = round(
            $inputs->totalPeople + Percentage::of($inputs->growthPercentage, $inputs->totalPeople)
        );

        $percentageToAccommodate = Arr::get(
            Arr::get(
                $this->config->workstyleParameters,
                $inputs->workstyle->value
            ),
            'hybrid-working.' . $inputs->hybridWorking->value
        );

        $undiversifiedAllocation = round(Percentage::of($inputs->deskPercentage, $peopleWorkingPlusGrowth));

        $diversifiedAllocation = round(
            Percentage::of(
                $percentageToAccommodate,
                $peopleWorkingPlusGrowth - $undiversifiedAllocation
            )
        );

        $mobility_adjuster = Arr::get($this->config->mobilityAdjusters, $inputs->mobility->value);

        $collaboration_adjuster = Arr::get($this->config->collaborationAdjusters, $inputs->collaboration->value);


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
