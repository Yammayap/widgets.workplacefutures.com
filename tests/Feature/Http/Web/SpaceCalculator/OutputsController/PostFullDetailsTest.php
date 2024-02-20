<?php

namespace Tests\Feature\Http\Web\SpaceCalculator\OutputsController;

use App\Actions\Enquiries\AddFullDetailsAction as AddFullDetailsToEnquiryAction;
use App\Actions\Users\AddFullDetailsAction as AddFullDetailsToUserAction;
use App\Jobs\Enquiries\TransmitToHubSpotJob;
use App\Models\Enquiry;
use App\Models\SpaceCalculatorInput;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PostFullDetailsTest extends TestCase
{
    public function test_posts_ok_with_minimal_data(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        AddFullDetailsToUserAction::shouldRun()
            ->once()
            ->with(
                $this->mockArgModel($user),
                'Liam',
                'Gallagher',
                null,
                null,
                false
            );

        AddFullDetailsToEnquiryAction::shouldRun()
            ->once()
            ->with(
                $this->mockArgModel($enquiry),
                null,
                false,
            );

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->post(route('web.space-calculator.outputs.full-details.post', $inputs), [
                'first_name' => 'Liam',
                'last_name' => 'Gallagher',
            ])
            ->assertRedirect(route('web.space-calculator.outputs.detailed', $inputs))
            ->assertSessionHasNoErrors();

        // todo: discuss - asserting queues for first time here, anything else we should test for?
        // or maybe add to it later when we have the job doing more?
        Queue::assertCount(1);
        Queue::assertPushed(TransmitToHubSpotJob::class);
    }

    public function test_posts_ok_with_more_data(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        AddFullDetailsToUserAction::shouldRun()
            ->once()
            ->with(
                $this->mockArgModel($user),
                'Liam',
                'Gallagher',
                'Oasis Co',
                '07787878787',
                true,
            );

        AddFullDetailsToEnquiryAction::shouldRun()
            ->once()
            ->with(
                $this->mockArgModel($enquiry),
                'Lorem ipsum dolor sit amet',
                true,
            );

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->post(route('web.space-calculator.outputs.full-details.post', $inputs), [
                'first_name' => 'Liam',
                'last_name' => 'Gallagher',
                'company_name' => 'Oasis Co',
                'phone' => '07787878787',
                'marketing_opt_in' => true,
                'message' => 'Lorem ipsum dolor sit amet',
                'can_contact' => true,
            ])
            ->assertRedirect(route('web.space-calculator.outputs.detailed', $inputs))
            ->assertSessionHasNoErrors();

        Queue::assertCount(1);
        Queue::assertPushed(TransmitToHubSpotJob::class);
    }

    /*
     * more...
     *
     * required_fields
     * other errors (invalid phone, booleans)
     * auth_user_gets_redirected_away
     * without_session_redirects_away
     * try_to_access_results_for_inputs_when_different_uuid_is_in_session
     *
     */
}
