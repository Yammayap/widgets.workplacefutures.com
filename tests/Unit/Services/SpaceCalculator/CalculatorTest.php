<?php

namespace Tests\Unit\Services\SpaceCalculator;

use App\Enums\Widgets\SpaceCalculator\AreaType;
use App\Enums\Widgets\SpaceCalculator\Asset;
use App\Enums\Widgets\SpaceCalculator\CapacityType;
use App\Enums\Widgets\SpaceCalculator\Collaboration;
use App\Enums\Widgets\SpaceCalculator\HybridWorking;
use App\Enums\Widgets\SpaceCalculator\Mobility;
use App\Enums\Widgets\SpaceCalculator\WorkstationType;
use App\Enums\Widgets\SpaceCalculator\Workstyle;
use App\Services\SpaceCalculator\Calculator;
use App\Services\SpaceCalculator\Inputs;
use Tests\TestCase;

class CalculatorTest extends TestCase
{
    public function test_output_with_inputs_set_one(): void
    {
        $calculator = app()->make(Calculator::class);

        $outputs = $calculator->calculate(new Inputs(
            Workstyle::PUBLIC_SECTOR,
            250,
            10,
            15,
            HybridWorking::TWO_DAYS,
            Mobility::LAPTOPS_ANYWHERE,
            Collaboration::ALL_COLLABORATION,
        ));

        $this->assertEquals(13400, $outputs->areaSize->tightSqFt);
        $this->assertEquals(1241, $outputs->areaSize->tightSqM);
        $this->assertEquals(15300, $outputs->areaSize->averageSqFt);
        $this->assertEquals(1421, $outputs->areaSize->averageSqM);
        $this->assertEquals(18700, $outputs->areaSize->spaciousSqFt);
        $this->assertEquals(1740, $outputs->areaSize->spaciousSqM);

        $this->assertCount(7, $outputs->capacityTypes);
        $this->assertEquals(368, $outputs->capacityTypes->sum('quantity'));
        $this->assertEquals(CapacityType::LONG_DWELL_WORKSTATION, $outputs->capacityTypes[0]->capacityType);
        $this->assertEquals(164, $outputs->capacityTypes[0]->quantity);
        $this->assertEquals(CapacityType::SHORT_DWELL_WORKSTATION, $outputs->capacityTypes[1]->capacityType);
        $this->assertEquals(22, $outputs->capacityTypes[1]->quantity);
        $this->assertEquals(CapacityType::FOCUS_SPACE, $outputs->capacityTypes[2]->capacityType);
        $this->assertEquals(28, $outputs->capacityTypes[2]->quantity);
        $this->assertEquals(CapacityType::BREAKOUT, $outputs->capacityTypes[3]->capacityType);
        $this->assertEquals(19, $outputs->capacityTypes[3]->quantity);
        $this->assertEquals(CapacityType::RECREATION, $outputs->capacityTypes[4]->capacityType);
        $this->assertEquals(0, $outputs->capacityTypes[4]->quantity);
        $this->assertEquals(CapacityType::TEAM_MEETING, $outputs->capacityTypes[5]->capacityType);
        $this->assertEquals(117, $outputs->capacityTypes[5]->quantity);
        $this->assertEquals(CapacityType::FRONT_OF_HOUSE, $outputs->capacityTypes[6]->capacityType);
        $this->assertEquals(18, $outputs->capacityTypes[6]->quantity);

        $this->assertCount(6, $outputs->areaTypes); // note: first one likely to change
        $this->assertEquals('workstations', $outputs->areaTypes[0]->areaType);
        $this->assertEquals(508.2052800000001, $outputs->areaTypes[0]->quantity);
        $this->assertEquals(AreaType::FOCUS, $outputs->areaTypes[1]->areaType);
        $this->assertEquals(60.4824, $outputs->areaTypes[1]->quantity);
        $this->assertEquals(AreaType::COLLABORATION, $outputs->areaTypes[2]->areaType);
        $this->assertEquals(282.42984, $outputs->areaTypes[2]->quantity);
        $this->assertEquals(AreaType::CONGREGATION_SPACE, $outputs->areaTypes[3]->areaType);
        $this->assertEquals(44.787600000000005, $outputs->areaTypes[3]->quantity);
        $this->assertEquals(AreaType::FRONT_OF_HOUSE, $outputs->areaTypes[4]->areaType);
        $this->assertEquals(90.63264672, $outputs->areaTypes[4]->quantity);
        $this->assertEquals(AreaType::FACILITIES, $outputs->areaTypes[5]->areaType);
        $this->assertEquals(50.721000000000004, $outputs->areaTypes[5]->quantity);

        // should we include not contains other assets (A: no)

        $pluckedAssets = $outputs->assets->pluck('asset');
        $this->assertCount(28, $outputs->assets);
        $this->assertContains(WorkstationType::PRIVATE_OFFICES, $pluckedAssets);
        $this->assertEquals(7, $outputs->assets[WorkstationType::PRIVATE_OFFICES->value]->quantity);
        $this->assertContains(WorkstationType::OPEN_PLAN_DESKS, $pluckedAssets);
        $this->assertEquals(156, $outputs->assets[WorkstationType::OPEN_PLAN_DESKS->value]->quantity);
        $this->assertContains(WorkstationType::OPEN_PLAN_TOUCHDOWN_DESKS, $pluckedAssets);
        $this->assertEquals(22, $outputs->assets[WorkstationType::OPEN_PLAN_TOUCHDOWN_DESKS->value]->quantity);
        $this->assertContains(Asset::PHONE_BOOTH, $pluckedAssets);
        $this->assertEquals(9, $outputs->assets[Asset::PHONE_BOOTH->value]->quantity);
        $this->assertContains(Asset::OPEN_BOOTH, $pluckedAssets);
        $this->assertEquals(8, $outputs->assets[Asset::OPEN_BOOTH->value]->quantity);
        $this->assertContains(Asset::FOCUS_BOOTH, $pluckedAssets);
        $this->assertEquals(6, $outputs->assets[Asset::FOCUS_BOOTH->value]->quantity);
        $this->assertContains(Asset::CHILL_QUIET_SPACE, $pluckedAssets);
        $this->assertEquals(5, $outputs->assets[Asset::CHILL_QUIET_SPACE->value]->quantity);
        $this->assertContains(Asset::OPEN_COLLABORATION_TOUCHDOWN, $pluckedAssets);
        $this->assertEquals(17, $outputs->assets[Asset::OPEN_COLLABORATION_TOUCHDOWN->value]->quantity);
        $this->assertContains(Asset::MEETING_BOOTH, $pluckedAssets);
        $this->assertEquals(4, $outputs->assets[Asset::MEETING_BOOTH->value]->quantity);
        $this->assertContains(Asset::TWO_PERSON_INTERVIEW_OR_VC_ROOM, $pluckedAssets);
        $this->assertEquals(8, $outputs->assets[Asset::TWO_PERSON_INTERVIEW_OR_VC_ROOM->value]->quantity);
        $this->assertContains(Asset::FOUR_PERSON_MEETING_ROOM, $pluckedAssets);
        $this->assertEquals(6, $outputs->assets[Asset::FOUR_PERSON_MEETING_ROOM->value]->quantity);
        $this->assertContains(Asset::EIGHT_PERSON_MEETING_ROOM, $pluckedAssets);
        $this->assertEquals(4, $outputs->assets[Asset::EIGHT_PERSON_MEETING_ROOM->value]->quantity);
        $this->assertContains(Asset::TWELVE_PERSON_MEETING_ROOM, $pluckedAssets);
        $this->assertEquals(1, $outputs->assets[Asset::TWELVE_PERSON_MEETING_ROOM->value]->quantity);
        $this->assertContains(Asset::TEAPOINT, $pluckedAssets);
        $this->assertEquals(2, $outputs->assets[Asset::TEAPOINT->value]->quantity);
        $this->assertContains(Asset::BREAKOUT_SEATS_OF_VARIOUS_TYPES, $pluckedAssets);
        $this->assertEquals(19, $outputs->assets[Asset::BREAKOUT_SEATS_OF_VARIOUS_TYPES->value]->quantity);
        $this->assertContains(Asset::RECEPTION_DESK_POSITIONS, $pluckedAssets);
        $this->assertEquals(1, $outputs->assets[Asset::RECEPTION_DESK_POSITIONS->value]->quantity);
        $this->assertContains(Asset::RECEPTION_WAITING_AREA_SEATS, $pluckedAssets);
        $this->assertEquals(6, $outputs->assets[Asset::RECEPTION_WAITING_AREA_SEATS->value]->quantity);
        $this->assertContains(Asset::RECEPTION_STORAGE, $pluckedAssets);
        $this->assertEquals(1, $outputs->assets[Asset::RECEPTION_STORAGE->value]->quantity);
        $this->assertContains(Asset::TWO_PERSON_INTERVIEW_ROOM, $pluckedAssets);
        $this->assertEquals(3, $outputs->assets[Asset::TWO_PERSON_INTERVIEW_ROOM->value]->quantity);
        $this->assertContains(Asset::FOUR_PERSON_CONFERENCE_ROOM, $pluckedAssets);
        $this->assertEquals(1, $outputs->assets[Asset::FOUR_PERSON_CONFERENCE_ROOM->value]->quantity);
        $this->assertContains(Asset::EIGHT_PERSON_CONFERENCE_ROOM, $pluckedAssets);
        $this->assertEquals(1, $outputs->assets[Asset::EIGHT_PERSON_CONFERENCE_ROOM->value]->quantity);
        $this->assertContains(Asset::COMMS_ROOM_OR_SER, $pluckedAssets);
        $this->assertEquals(1, $outputs->assets[Asset::COMMS_ROOM_OR_SER->value]->quantity);
        $this->assertContains(Asset::PRINT_AND_COPY_AREA, $pluckedAssets);
        $this->assertEquals(3, $outputs->assets[Asset::PRINT_AND_COPY_AREA->value]->quantity);
        $this->assertContains(Asset::FACILITIES_STORE, $pluckedAssets);
        $this->assertEquals(1, $outputs->assets[Asset::FACILITIES_STORE->value]->quantity);
        $this->assertContains(Asset::COAT_STORAGE, $pluckedAssets);
        $this->assertEquals(5, $outputs->assets[Asset::COAT_STORAGE->value]->quantity);
        $this->assertContains(Asset::CLEANERS_CUPBOARD, $pluckedAssets);
        $this->assertEquals(1, $outputs->assets[Asset::CLEANERS_CUPBOARD->value]->quantity);
        $this->assertContains(Asset::CLEANERS_CUPBOARD, $pluckedAssets);
        $this->assertEquals(1, $outputs->assets[Asset::CLEANERS_CUPBOARD->value]->quantity);
        $this->assertContains(Asset::PRAYER_ROOM, $pluckedAssets);
        $this->assertEquals(1, $outputs->assets[Asset::PRAYER_ROOM->value]->quantity);
        $this->assertContains(Asset::FOUR_HIGH_LOCKERS, $pluckedAssets);
        $this->assertEquals(12, $outputs->assets[Asset::FOUR_HIGH_LOCKERS->value]->quantity);

        //dd($outputs->assets);
    }

    /*
     * tests to do
     *
     * output set 2
     * output set 3
     * output set 4
     * output set 5
     * output set 6
     * name: test_output_with_inputs_set_NUMBER_HERE
     *
     */
}
