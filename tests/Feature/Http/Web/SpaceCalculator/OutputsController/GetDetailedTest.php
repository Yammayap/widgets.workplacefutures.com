<?php

namespace Tests\Feature\Http\Web\SpaceCalculator\OutputsController;

use App\Models\Enquiry;
use App\Models\SpaceCalculatorInput;
use App\Models\User;
use App\Services\SpaceCalculator\Calculator;
use App\Services\SpaceCalculator\Output;
use App\Services\SpaceCalculator\OutputAreaSize;
use Tests\TestCase;

class GetDetailedTest extends TestCase
{
    public function test_page_loads_ok_for_guest_after_completing_profile(): void
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
            ->get(route('web.space-calculator.outputs.detailed', $inputs->uuid))
            ->assertOk()
            ->assertViewIs('web.space-calculator.detailed-results');
    }

    public function test_page_loads_ok_for_authenticated_user_when_enquiry_is_theirs(): void
    {
        $user = User::factory()->create(['has_completed_profile' => true]);
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->authenticateUser($user);

        $this->mock(Calculator::class)
            ->shouldReceive("calculate")
            ->andReturn(new Output(
                areaSize: new OutputAreaSize(0, 0, 0, 0, 0, 0),
                assets: collect(),
                capacityTypes: collect(),
                areaTypes: collect(),
            ));

        $this->get(route('web.space-calculator.outputs.detailed', $inputs->uuid))
            ->assertOk()
            ->assertViewIs('web.space-calculator.detailed-results');
    }

    // todo: discuss - is this too over the top for testing? Since auth user's don't have session check in middleware
    public function test_page_loads_ok_for_authenticated_user_when_enquiry_is_theirs_and_session_is_different_uuid(): void
    {
        $user = User::factory()->create(['has_completed_profile' => true]);
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->authenticateUser($user);

        $this->mock(Calculator::class)
            ->shouldReceive("calculate")
            ->andReturn(new Output(
                areaSize: new OutputAreaSize(0, 0, 0, 0, 0, 0),
                assets: collect(),
                capacityTypes: collect(),
                areaTypes: collect(),
            ));

        $this->withSession([config('widgets.space-calculator.input-session-key') => $this->faker->uuid])
            ->get(route('web.space-calculator.outputs.detailed', $inputs->uuid))
            ->assertOk()
            ->assertViewIs('web.space-calculator.detailed-results');
    }

    /*
     * more to test
     *
     * GUEST REDIRECTS
     * guest user incomplete profile redirect
     * guest access without user set up yet redirect
     * guest without session
     * guess with session different inputs uuid
     *
     * AUTH USER REDIRECTS
     * auth user incomplete profile redirect
     * auth user can't access if enquiry isn't theirs
     * auth user can't access if enquiry isn't theirs but has session containing their uuid
     *
     */
}
