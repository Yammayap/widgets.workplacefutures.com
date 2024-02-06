<?php

namespace Feature\Http\Web\SpaceCalculator\InputsController;

use App\Actions\Enquiries\CreateAction as CreateEnquiryAction;
use App\Actions\SpaceCalculatorInputs\CreateAction as CreateSpaceCalculatorInputAction;
use App\Enums\Widgets\SpaceCalculator\Collaboration;
use App\Enums\Widgets\SpaceCalculator\HybridWorking;
use App\Enums\Widgets\SpaceCalculator\Mobility;
use App\Enums\Widgets\SpaceCalculator\Workstyle;
use App\Models\Enquiry;
use Tests\TestCase;

class PostIndexTest extends TestCase
{
    public function test_can_post_inputs_and_creates_one_enquiry_and_one_input(): void
    {
        CreateEnquiryAction::shouldRun()
            ->once()
            ->withNoArgs()
            ->andReturn($enquiry = Enquiry::factory()->create());

        CreateSpaceCalculatorInputAction::shouldRun()
            ->once()
            ->with(
                Workstyle::FINANCIAL,
                8,
                40,
                25,
                HybridWorking::THREE_DAYS,
                Mobility::COMPUTER_MIXTURE,
                Collaboration::MANY_MEETINGS,
                $enquiry,
            );

        $this->post(route('web.space-calculator.inputs.post'), [
            'workstyle' => Workstyle::FINANCIAL->value,
            'total_people' => 8,
            'growth_percentage' => 40,
            'desk_percentage' => 25,
            'hybrid_working' => HybridWorking::THREE_DAYS->value,
            'mobility' => Mobility::COMPUTER_MIXTURE->value,
            'collaboration' => Collaboration::MANY_MEETINGS->value,
        ])->assertRedirect()
            ->assertSessionHasNoErrors();
    }

    public function test_required_fields(): void
    {
        CreateEnquiryAction::shouldNotRun();
        CreateSpaceCalculatorInputAction::shouldNotRun();

        $this->post(route('web.space-calculator.inputs.post'), [
            //
        ])->assertRedirect()
            ->assertSessionHasErrors([
                'workstyle',
                'total_people',
                'growth_percentage',
                'desk_percentage',
                'hybrid_working',
                'mobility',
                'collaboration',
            ]);
    }

    public function test_other_errors(): void
    {
        CreateEnquiryAction::shouldNotRun();
        CreateSpaceCalculatorInputAction::shouldNotRun();

        $this->post(route('web.space-calculator.inputs.post'), [
            'workstyle' => 'super_efficient',
            'total_people' => 'eight',
            'growth_percentage' => 'a lot',
            'desk_percentage' => 'plenty',
            'hybrid_working' => 'many_days',
            'mobility' => 'very_mobile',
            'collaboration' => 'team_work_is_great',
        ])->assertRedirect()
            ->assertSessionHasErrors([
                'workstyle',
                'total_people',
                'growth_percentage',
                'desk_percentage',
                'hybrid_working',
                'mobility',
                'collaboration',
            ]);
    }

    public function test_minimal_amounts_on_number_fields(): void
    {
        CreateEnquiryAction::shouldNotRun();
        CreateSpaceCalculatorInputAction::shouldNotRun();

        $this->post(route('web.space-calculator.inputs.post'), [
            'workstyle' => Workstyle::FINANCIAL->value,
            'total_people' => 0,
            'growth_percentage' => -1,
            'desk_percentage' => -1,
            'hybrid_working' => HybridWorking::THREE_DAYS->value,
            'mobility' => Mobility::COMPUTER_MIXTURE->value,
            'collaboration' => Collaboration::MANY_MEETINGS->value,
        ])->assertRedirect()
            ->assertSessionHasErrors([
                'total_people',
                'growth_percentage',
                'desk_percentage',
            ]);
    }
}
