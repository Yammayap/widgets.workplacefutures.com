<?php

namespace Feature\Http\Web\SpaceCalculator\OutputsController;

use App\Models\SpaceCalculatorInput;
use Tests\TestCase;

class GetIndexTest extends TestCase
{
    public function test_page_loads_ok_for_guest_after_posting_inputs(): void
    {
        // todo: discuss mocking here

        $inputs = SpaceCalculatorInput::factory()->create();

        $this->withSession([config('widgets.space-calculator.outputs-summary-session-id-key') => $inputs->uuid]);

        $response = $this->get(route('web.space-calculator.outputs.index', $inputs->uuid));

        $response->assertOk()
            ->assertViewIs('web.space-calculator.outputs');
    }

    public function test_auth_user_gets_redirected_away(): void
    {
        // mocking here

        $this->authenticateUser();

        $inputs = SpaceCalculatorInput::factory()->create();

        $this->withSession([config('widgets.space-calculator.outputs-summary-session-id-key') => $inputs->uuid]);

        $response = $this->get(route('web.space-calculator.outputs.index', $inputs->uuid));

        $response->assertRedirect(route('web.space-calculator.index'));
    }

    public function test_without_session_redirects_away(): void
    {
        // mocking here

        $inputs = SpaceCalculatorInput::factory()->create();

        $response = $this->get(route('web.space-calculator.outputs.index', $inputs->uuid));

        $response->assertRedirect(route('web.space-calculator.index'));
    }

    public function test_try_to_access_results_for_inputs_when_different_uuid_is_in_session(): void
    {
        // mocking here

        $this->authenticateUser();

        $inputs_1 = SpaceCalculatorInput::factory()->create();
        $inputs_2 = SpaceCalculatorInput::factory()->create();

        $this->withSession([config('widgets.space-calculator.outputs-summary-session-id-key') => $inputs_1->uuid]);

        $response = $this->get(route('web.space-calculator.outputs.index', $inputs_2->uuid));

        $response->assertRedirect(route('web.space-calculator.index'));
    }
}
