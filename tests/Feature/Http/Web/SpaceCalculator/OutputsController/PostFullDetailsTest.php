<?php

namespace Tests\Feature\Http\Web\SpaceCalculator\OutputsController;

use App\Actions\Enquiries\AddContactDetailsAction;
use App\Actions\Users\UpdateProfileAction;
use App\Jobs\Enquiries\TransmitToHubSpotJob;
use App\Models\Enquiry;
use App\Models\SpaceCalculatorInput;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Propaganistas\LaravelPhone\PhoneNumber;
use Tests\TestCase;

class PostFullDetailsTest extends TestCase
{
    public function test_posts_ok_with_minimal_data(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        UpdateProfileAction::shouldRun()
            ->once()
            ->with(
                $this->mockArgModel($user),
                'Liam',
                'Gallagher',
                null,
                null,
                false
            );

        AddContactDetailsAction::shouldRun()
            ->once()
            ->with(
                $this->mockArgModel($enquiry),
                null,
                false,
            );

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->post(route('web.space-calculator.outputs.profile.post', $inputs), [
                'first_name' => 'Liam',
                'last_name' => 'Gallagher',
            ])
            ->assertRedirect(route('web.space-calculator.outputs.detailed', $inputs))
            ->assertSessionHasNoErrors();

        Queue::assertCount(1);
        Queue::assertPushed(TransmitToHubSpotJob::class);
        Queue::assertPushed(function (TransmitToHubSpotJob $job) use ($enquiry) {
            return $job->enquiry->id === $enquiry->id;
        });
    }

    public function test_posts_ok_with_more_data(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        UpdateProfileAction::shouldRun()
            ->once()
            ->with(
                $this->mockArgModel($user),
                'Liam',
                'Gallagher',
                'Oasis Co',
                Mockery::on(function (PhoneNumber $arg) {
                    return $arg->formatE164() === '+447787878787';
                }),
                true,
            );

        AddContactDetailsAction::shouldRun()
            ->once()
            ->with(
                $this->mockArgModel($enquiry),
                'Lorem ipsum dolor sit amet',
                true,
            );

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->post(route('web.space-calculator.outputs.profile.post', $inputs), [
                'first_name' => 'Liam',
                'last_name' => 'Gallagher',
                'company_name' => 'Oasis Co',
                'phone' => new PhoneNumber('+447787878787', null),
                'marketing_opt_in' => true,
                'message' => 'Lorem ipsum dolor sit amet',
                'can_contact' => true,
            ])
            ->assertRedirect(route('web.space-calculator.outputs.detailed', $inputs))
            ->assertSessionHasNoErrors();

        Queue::assertCount(1);
        Queue::assertPushed(TransmitToHubSpotJob::class);
    }

    public function test_required_fields(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        UpdateProfileAction::shouldNotRun();
        AddContactDetailsAction::shouldNotRun();

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->post(route('web.space-calculator.outputs.profile.post', $inputs), [
                //
            ])
            ->assertRedirect()
            ->assertSessionHasErrors([
                'first_name',
                'last_name',
            ]);

        Queue::assertNothingPushed();
        Queue::assertNotPushed(TransmitToHubSpotJob::class);
    }

    public function test_other_errors(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        UpdateProfileAction::shouldNotRun();
        AddContactDetailsAction::shouldNotRun();

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->post(route('web.space-calculator.outputs.profile.post', $inputs), [
                'first_name' => 'Liam',
                'last_name' => 'Gallagher',
                'company_name' => 'Oasis Co',
                'phone' => 'This is a string',
                'marketing_opt_in' => 'true',
                'message' => 'Lorem ipsum dolor sit amet',
                'can_contact' => 'false',
            ])
            ->assertRedirect()
            ->assertSessionHasErrors([
                'phone',
                'marketing_opt_in',
                'can_contact',
            ]);

        Queue::assertNothingPushed();
        Queue::assertNotPushed(TransmitToHubSpotJob::class);
    }

    public function test_auth_user_gets_redirected_away(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->authenticateUser($user);

        UpdateProfileAction::shouldNotRun();
        AddContactDetailsAction::shouldNotRun();

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->post(route('web.space-calculator.outputs.profile.post', $inputs), [
                'first_name' => 'Liam',
                'last_name' => 'Gallagher',
            ])
            ->assertRedirect();

        Queue::assertNothingPushed();
        Queue::assertNotPushed(TransmitToHubSpotJob::class);
    }

    public function test_without_session_redirects_away(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        UpdateProfileAction::shouldNotRun();
        AddContactDetailsAction::shouldNotRun();

        $this->post(route('web.space-calculator.outputs.profile.post', $inputs), [
                'first_name' => 'Liam',
                'last_name' => 'Gallagher',
            ])
            ->assertRedirect();

        Queue::assertNothingPushed();
        Queue::assertNotPushed(TransmitToHubSpotJob::class);
    }

    public function test_try_to_access_results_for_inputs_when_different_uuid_is_in_session(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        UpdateProfileAction::shouldNotRun();
        AddContactDetailsAction::shouldNotRun();

        $this->withSession([config('widgets.space-calculator.input-session-key') => $this->faker->uuid])
            ->post(route('web.space-calculator.outputs.profile.post', $inputs), [
            'first_name' => 'Liam',
            'last_name' => 'Gallagher',
        ])
            ->assertRedirect();

        Queue::assertNothingPushed();
        Queue::assertNotPushed(TransmitToHubSpotJob::class);
    }
}
