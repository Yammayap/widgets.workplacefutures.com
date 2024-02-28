<?php

namespace Feature\Http\Web\SpaceCalculator\InputsController;

use App\Actions\Enquiries\CreateAction as CreateEnquiryAction;
use App\Actions\SpaceCalculatorInputs\CreateAction as CreateSpaceCalculatorInputAction;
use App\Enums\Tenant;
use App\Enums\Widget;
use App\Enums\Widgets\SpaceCalculator\Collaboration;
use App\Enums\Widgets\SpaceCalculator\HybridWorking;
use App\Enums\Widgets\SpaceCalculator\Mobility;
use App\Enums\Widgets\SpaceCalculator\Workstyle;
use App\Models\Enquiry;
use App\Models\SpaceCalculatorInput;
use App\Models\User;
use Tests\TestCase;

class PostIndexTest extends TestCase
{
    public function test_can_post_as_guest_inputs_and_creates_one_enquiry_and_one_input(): void
    {
        $this->assertGuest();

        CreateEnquiryAction::shouldRun()
            ->once()
            ->with(
                Tenant::WFG,
                Widget::SPACE_CALCULATOR,
                null,
                null,
                false,
            )
            ->andReturn($enquiry = Enquiry::factory()->create());

        CreateSpaceCalculatorInputAction::shouldRun()
            ->once()
            ->with(
                $enquiry,
                Workstyle::FINANCIAL,
                8,
                40,
                25,
                HybridWorking::THREE_DAYS,
                Mobility::COMPUTER_MIXTURE,
                Collaboration::MANY_MEETINGS,
            )
            ->andReturn($input = SpaceCalculatorInput::factory()->create());

        $this->post(route('web.space-calculator.inputs.post'), [
            'workstyle' => Workstyle::FINANCIAL->value,
            'total_people' => 8,
            'growth_percentage' => 40,
            'desk_percentage' => 25,
            'hybrid_working' => HybridWorking::THREE_DAYS->value,
            'mobility' => Mobility::COMPUTER_MIXTURE->value,
            'collaboration' => Collaboration::MANY_MEETINGS->value,
        ])->assertRedirect(route('web.space-calculator.outputs.summary', $input))
            ->assertSessionHasNoErrors()
            ->assertSessionHas(config('widgets.space-calculator.input-session-key'), $input->uuid);
    }

    public function test_can_post_as_authenticated_user_inputs_and_creates_one_enquiry_and_one_input(): void
    {
        $user = User::factory()->create();
        $this->authenticateUser($user);

        CreateEnquiryAction::shouldRun()
            ->once()
            ->with(
                Tenant::WFG,
                Widget::SPACE_CALCULATOR,
                $user,
                'Lorem ipsum dolor sit amet',
                true,
            )
            ->andReturn($enquiry = Enquiry::factory()->create());

        CreateSpaceCalculatorInputAction::shouldRun()
            ->once()
            ->with(
                $enquiry,
                Workstyle::FINANCIAL,
                8,
                40,
                25,
                HybridWorking::THREE_DAYS,
                Mobility::COMPUTER_MIXTURE,
                Collaboration::MANY_MEETINGS,
            )
            ->andReturn($input = SpaceCalculatorInput::factory()->create());

        $this->post(route('web.space-calculator.inputs.post'), [
            'workstyle' => Workstyle::FINANCIAL->value,
            'total_people' => 8,
            'growth_percentage' => 40,
            'desk_percentage' => 25,
            'hybrid_working' => HybridWorking::THREE_DAYS->value,
            'mobility' => Mobility::COMPUTER_MIXTURE->value,
            'collaboration' => Collaboration::MANY_MEETINGS->value,
            'message' => 'Lorem ipsum dolor sit amet',
            'can_contact' => true,
        ])->assertRedirect(route('web.space-calculator.outputs.summary', $input))
            ->assertSessionHasNoErrors()
            ->assertSessionHas(config('widgets.space-calculator.input-session-key'), $input->uuid);
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
            ])->assertSessionMissing(config('widgets.space-calculator.input-session-key'));
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
            ])->assertSessionMissing(config('widgets.space-calculator.input-session-key'));
    }

    public function test_other_errors_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        $this->authenticateUser($user);

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
            'message' => 'This is fine',
            'can_contact' => 'true',
        ])->assertRedirect()
            ->assertSessionHasErrors([
                'workstyle',
                'total_people',
                'growth_percentage',
                'desk_percentage',
                'hybrid_working',
                'mobility',
                'collaboration',
                'can_contact'
            ])->assertSessionMissing(config('widgets.space-calculator.input-session-key'));
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
            ])->assertSessionMissing(config('widgets.space-calculator.input-session-key'));
    }
}
