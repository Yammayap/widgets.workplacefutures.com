<?php

namespace Feature\Http\Web\SpaceCalculator\OutputsController;

use App\Actions\Enquiries\AttachToUserAction;
use App\Actions\MagicLinks\SendAction;
use App\Actions\Users\CreateAction;
use App\Models\Enquiry;
use App\Models\SpaceCalculatorInput;
use App\Models\User;
use App\Notifications\SpaceCalculator\SummaryNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PostSummaryTest extends TestCase
{
    public function test_posts_ok_for_guest_posting_email_for_existing_user_with_complete_profile(): void
    {
        $user = User::factory()->create(['has_completed_profile' => true]);
        $inputs = SpaceCalculatorInput::factory()->create();

        SendAction::shouldRun()
            ->once()
            ->with(
                $this->mockArgModel($user),
                '127.0.0.1',
                route('web.space-calculator.outputs.detailed', $inputs),
            );

        AttachToUserAction::shouldRun()
            ->once()
            ->with(
                $this->mockArgModel($inputs->enquiry),
                $this->mockArgModel($user),
            );

        CreateAction::shouldNotRun();

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->post(route('web.space-calculator.outputs.summary.post', $inputs), [
                'email' => $user->email,
            ])
            ->assertRedirect(route('web.auth.sent'))
            ->assertSessionHasNoErrors();
    }

    public function test_posts_ok_for_guest_posting_email_for_existing_user_without_complete_profile(): void
    {
        Notification::fake();

        $user = User::factory()->create(['has_completed_profile' => false]);
        $enquiry = Enquiry::factory()->create();
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        SendAction::shouldNotRun();
        CreateAction::shouldNotRun();

        AttachToUserAction::shouldRun()
            ->once()
            ->with(
                $this->mockArgModel($enquiry),
                $this->mockArgModel($user),
            );

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->post(route('web.space-calculator.outputs.summary.post', $inputs), [
                'email' => $user->email,
            ])
            ->assertRedirect(route('web.space-calculator.outputs.summary', $inputs))
            ->assertSessionHasNoErrors();

        Notification::assertCount(1);
        Notification::assertSentTo(
            $user,
            SummaryNotification::class,
        );
    }

    public function test_posts_ok_for_guest_posting_email_when_no_user_with_that_email_exists(): void
    {
        Notification::fake();

        $user = User::factory()->create(['email' => 'test@yammayap.com']);
        $enquiry = Enquiry::factory()->create();
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        SendAction::shouldNotRun();

        CreateAction::shouldRun()
            ->once()
            ->with('john@yammayap.com')
            ->andReturn($newUser = User::factory()->create());

        AttachToUserAction::shouldRun()
            ->once()
            ->with(
                $this->mockArgModel($enquiry),
                $this->mockArgModel($newUser),
            );

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->post(route('web.space-calculator.outputs.summary.post', $inputs), [
                'email' => 'john@yammayap.com',
            ])
            ->assertRedirect(route('web.space-calculator.outputs.summary', $inputs))
            ->assertSessionHasNoErrors();

        Notification::assertCount(1);
        Notification::assertNotSentTo(
            $user,
            SummaryNotification::class,
        );
    }

    public function test_required_fields(): void
    {
        Notification::fake();

        $inputs = SpaceCalculatorInput::factory()->create();

        SendAction::shouldNotRun();
        CreateAction::shouldNotRun();
        AttachToUserAction::shouldNotRun();

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->post(route('web.space-calculator.outputs.summary.post', $inputs), [
                //
            ])
            ->assertRedirect()
            ->assertSessionHasErrors([
                'email'
            ]);

        Notification::assertCount(0);
    }

    public function test_auth_user_gets_redirected_away(): void
    {
        Notification::fake();

        $this->authenticateUser();

        $inputs = SpaceCalculatorInput::factory()->create();

        SendAction::shouldNotRun();
        CreateAction::shouldNotRun();
        AttachToUserAction::shouldNotRun();

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->post(route('web.space-calculator.outputs.detailed', $inputs), [
                'email' => $this->faker->email,
            ])
            ->assertRedirect(route('web.portal.index'));

        Notification::assertCount(0);
    }

    public function test_without_session_redirects_away(): void
    {
        Notification::fake();

        $inputs = SpaceCalculatorInput::factory()->create();

        SendAction::shouldNotRun();
        CreateAction::shouldNotRun();
        AttachToUserAction::shouldNotRun();

        $this->post(route('web.space-calculator.outputs.summary.post', $inputs), [
                'email' => $this->faker->email,
            ])
            ->assertRedirect(route('web.space-calculator.index'));

        Notification::assertCount(0);
    }

    public function test_try_to_access_results_for_inputs_when_different_uuid_is_in_session(): void
    {
        Notification::fake();

        $inputs = SpaceCalculatorInput::factory()->create();

        SendAction::shouldNotRun();
        CreateAction::shouldNotRun();
        AttachToUserAction::shouldNotRun();

        $this->withSession([config('widgets.space-calculator.input-session-key') => $this->faker->uuid])
            ->post(route('web.space-calculator.outputs.summary.post', $inputs), [
                'email' => $this->faker->email,
            ])
            ->assertRedirect(route('web.space-calculator.index'));

        Notification::assertCount(0);
    }
}
