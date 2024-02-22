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

    public function test_redirect_for_guest_with_incomplete_profile(): void
    {
        $user = User::factory()->create(['has_completed_profile' => false]);
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->mock(Calculator::class)
            ->shouldNotHaveBeenCalled();

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->get(route('web.space-calculator.outputs.detailed', $inputs->uuid))
            ->assertRedirect(route('web.space-calculator.index'));
    }

    public function test_redirect_for_guest_before_user_set_up(): void
    {
        $inputs = SpaceCalculatorInput::factory()->create();

        $this->mock(Calculator::class)
            ->shouldNotHaveBeenCalled();

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->get(route('web.space-calculator.outputs.detailed', $inputs->uuid))
            ->assertRedirect(route('web.space-calculator.index'));
    }

    public function test_redirect_for_guest_without_session(): void
    {
        $user = User::factory()->create(['has_completed_profile' => true]);
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->mock(Calculator::class)
            ->shouldNotHaveBeenCalled();

        $this->get(route('web.space-calculator.outputs.detailed', $inputs->uuid))
            ->assertRedirect(route('web.space-calculator.index'));
    }

    public function test_redirect_for_guest_with_different_uuid_in_session(): void
    {
        $user = User::factory()->create(['has_completed_profile' => true]);
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->mock(Calculator::class)
            ->shouldNotHaveBeenCalled();

        $this->withSession([config('widgets.space-calculator.input-session-key') => $this->faker->uuid])
            ->get(route('web.space-calculator.outputs.detailed', $inputs->uuid))
            ->assertRedirect(route('web.space-calculator.index'));
    }

    public function test_redirect_for_authenticated_user_with_incomplete_profile(): void
    {
        $user = User::factory()->create(['has_completed_profile' => false]);
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->authenticateUser($user);

        $this->mock(Calculator::class)
            ->shouldNotHaveBeenCalled();

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->get(route('web.space-calculator.outputs.detailed', $inputs->uuid))
            ->assertRedirect(route('web.portal.index'));
    }

    public function test_redirect_for_authenticated_user_if_enquiry_is_not_theirs(): void
    {
        $user = User::factory()->create(['has_completed_profile' => true]);
        $enquiry = Enquiry::factory()->create(['user_id' => User::factory()->make()->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->authenticateUser($user);

        $this->mock(Calculator::class)
            ->shouldNotHaveBeenCalled();

        $this->get(route('web.space-calculator.outputs.detailed', $inputs->uuid))
            ->assertRedirect(route('web.portal.index'));
    }

    // todo: discuss - this one possibly over the top or worth testing?
    public function test_redirect_for_authenticated_user_if_enquiry_is_not_theirs_even_though_the_inputs_uuid_is_in_the_session(): void
    {
        $user = User::factory()->create(['has_completed_profile' => true]);
        $enquiry = Enquiry::factory()->create(['user_id' => User::factory()->make()->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->authenticateUser($user);

        $this->mock(Calculator::class)
            ->shouldNotHaveBeenCalled();

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->get(route('web.space-calculator.outputs.detailed', $inputs->uuid))
            ->assertRedirect(route('web.portal.index'));
    }
}
