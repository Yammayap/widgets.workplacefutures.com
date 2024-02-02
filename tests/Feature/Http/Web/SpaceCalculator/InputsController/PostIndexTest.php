<?php

namespace Feature\Http\Web\SpaceCalculator\InputsController;

use App\Enums\Tenant;
use App\Enums\Widget;
use App\Enums\Widgets\SpaceCalculator\Collaboration;
use App\Enums\Widgets\SpaceCalculator\HybridWorking;
use App\Enums\Widgets\SpaceCalculator\Mobility;
use App\Enums\Widgets\SpaceCalculator\Workstyle;
use App\Models\Enquiry;
use App\Models\SpaceCalculatorInput;
use Tests\TestCase;

class PostIndexTest extends TestCase
{
    public function test_can_post_inputs_and_creates_one_enquiry_and_one_input(): void
    {
        $this->assertEquals(0, Enquiry::count());
        $this->assertEquals(0, SpaceCalculatorInput::count());

        /*CreateAndGetEnquiryAction::shouldRun()
            ->once();
            //->withNoArgs();

        // todo: discuss - with() functions on action mocks not working
        // assert counts equal 1 at the end only pass if these actions mock tests are commented out

        CreateInputAction::shouldRun()
            ->once();
            /*->with(
                Workstyle::FINANCIAL,
                8,
                40,
                25,
                HybridWorking::THREE_DAYS,
                Mobility::COMPUTER_MIXTURE,
                Collaboration::MANY_MEETINGS,
            );*/

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

        $this->assertEquals(1, Enquiry::count());
        $this->assertEquals(1, SpaceCalculatorInput::count());

        $enquiry = Enquiry::query()->first();
        $input = SpaceCalculatorInput::query()->first();

        $this->assertNotNull($enquiry);
        $this->assertNotNull($input);
        $this->assertNull($enquiry->user_id);
        $this->assertEquals(Tenant::WFG, $enquiry->tenant);
        $this->assertEquals(Widget::SPACE_CALCULATOR, $enquiry->widget);
        $this->assertNull($enquiry->message);
        $this->assertFalse($enquiry->can_contact);
    }

    public function test_required_fields(): void
    {
        $this->assertEquals(0, Enquiry::count());
        $this->assertEquals(0, SpaceCalculatorInput::count());

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

        $this->assertEquals(0, Enquiry::count());
        $this->assertEquals(0, SpaceCalculatorInput::count());
    }

    public function test_other_errors(): void
    {
        $this->assertEquals(0, Enquiry::count());
        $this->assertEquals(0, SpaceCalculatorInput::count());

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

        $this->assertEquals(0, Enquiry::count());
        $this->assertEquals(0, SpaceCalculatorInput::count());
    }

    public function test_minimal_amounts_on_number_fields(): void
    {
        $this->assertEquals(0, Enquiry::count());
        $this->assertEquals(0, SpaceCalculatorInput::count());

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

        $this->assertEquals(0, Enquiry::count());
        $this->assertEquals(0, SpaceCalculatorInput::count());
    }
}
