<?php

namespace Feature\Http\Web\SpaceCalculator\OutputsController;

use App\Models\Enquiry;
use App\Models\SpaceCalculatorInput;
use App\Models\User;
use App\Services\SpaceCalculator\Calculator;
use App\Services\SpaceCalculator\Output;
use App\Services\SpaceCalculator\OutputAreaSize;
use Tests\TestCase;

class GetIndexTest extends TestCase
{
    public function test_page_loads_ok_for_guest_after_posting_inputs(): void
    {
        $inputs = SpaceCalculatorInput::factory()->create();

        $this->mock(Calculator::class)
            ->shouldReceive("calculate")
            ->andReturn(new Output(
                areaSize: new OutputAreaSize(0, 0, 0, 0, 0, 0),
                assets: collect(),
                capacityTypes: collect(),
                areaTypes: collect(),
            ));

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->get(route('web.space-calculator.outputs.index', $inputs->uuid))
            ->assertOk()
            ->assertViewIs('web.space-calculator.outputs')
            ->assertSeeText('Get results PDF')
            ->assertDontSeeText('Capture full details');
    }

    public function test_see_capture_full_details_form_after_posting_pdf_form_for_user_who_has_incomplete_profile(): void
    {
        $user = User::factory()->create(['has_completed_profile' => true]);
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->mock(Calculator::class)
            ->shouldReceive("calculate")
            ->andReturn(new Output(
                areaSize: new OutputAreaSize(0, 0, 0, 0, 0, 0),
                assets: collect(),
                capacityTypes: collect(),
                areaTypes: collect(),
            ));

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->get(route('web.space-calculator.outputs.index', $inputs->uuid))
            ->assertOk()
            ->assertViewIs('web.space-calculator.outputs')
            ->assertSeeText('Capture full details')
            ->assertDontSeeText('Get results PDF');
    }

    public function test_auth_user_gets_redirected_away(): void
    {
        $this->mock(Calculator::class);

        $this->authenticateUser();

        $inputs = SpaceCalculatorInput::factory()->create();

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->get(route('web.space-calculator.outputs.index', $inputs->uuid))
            ->assertRedirect(route('web.space-calculator.index'));
    }

    public function test_without_session_redirects_away(): void
    {
        $this->mock(Calculator::class);

        $inputs = SpaceCalculatorInput::factory()->create();

        $this->get(route('web.space-calculator.outputs.index', $inputs->uuid))
            ->assertRedirect(route('web.space-calculator.index'));
    }

    public function test_try_to_access_results_for_inputs_when_different_uuid_is_in_session(): void
    {
        $this->mock(Calculator::class);

        $this->authenticateUser();

        $inputs_1 = SpaceCalculatorInput::factory()->create();
        $inputs_2 = SpaceCalculatorInput::factory()->create();

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs_1->uuid])
            ->get(route('web.space-calculator.outputs.index', $inputs_2->uuid))
            ->assertRedirect(route('web.space-calculator.index'));
    }
}
