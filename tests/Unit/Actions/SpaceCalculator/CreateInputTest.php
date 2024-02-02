<?php

namespace Tests\Unit\Actions\SpaceCalculator;

use App\Actions\SpaceCalculator\CreateInputAction;
use App\Enums\Widgets\SpaceCalculator\Collaboration;
use App\Enums\Widgets\SpaceCalculator\HybridWorking;
use App\Enums\Widgets\SpaceCalculator\Mobility;
use App\Enums\Widgets\SpaceCalculator\Workstyle;
use App\Models\Enquiry;
use App\Models\SpaceCalculatorInput;
use Tests\TestCase;

class CreateInputTest extends TestCase
{
    public function test_input_is_created(): void
    {
        $this->assertEquals(0, SpaceCalculatorInput::count());

        CreateInputAction::run(
            Workstyle::PUBLIC_SECTOR,
            8,
            40,
            55,
            HybridWorking::FOUR_DAYS,
            Mobility::LAPTOPS_DOCKING,
            Collaboration::ALL_COLLABORATION,
            Enquiry::factory()->create(),
        );

        $this->assertEquals(1, SpaceCalculatorInput::count());

        $input = SpaceCalculatorInput::query()->first();

        $this->assertNotNull($input);
        $this->assertEquals(Workstyle::PUBLIC_SECTOR, $input->workstyle);
        $this->assertEquals(8, $input->total_people);
        $this->assertEquals(40, $input->growth_percentage);
        $this->assertEquals(55, $input->desk_percentage);
        $this->assertEquals(HybridWorking::FOUR_DAYS, $input->hybrid_working);
        $this->assertEquals(Mobility::LAPTOPS_DOCKING, $input->mobility);
        $this->assertEquals(Collaboration::ALL_COLLABORATION, $input->collaboration);
        $this->assertNotNull($input->enquiry_id);
    }
}
