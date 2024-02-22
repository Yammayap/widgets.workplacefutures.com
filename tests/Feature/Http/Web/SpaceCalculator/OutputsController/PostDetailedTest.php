<?php

namespace Tests\Feature\Http\Web\SpaceCalculator\OutputsController;

use App\Models\Enquiry;
use App\Models\SpaceCalculatorInput;
use App\Models\User;
use App\Notifications\DetailedNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PostDetailedTest extends TestCase
{
    public function test_posts_ok_for_guest(): void
    {
        Notification::fake();

        $user = User::factory()->create(['has_completed_profile' => true]);
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->post(route('web.space-calculator.outputs.detailed.post', $inputs))
            ->assertRedirect(route('web.space-calculator.outputs.detailed.post', $inputs))
            ->assertSessionHasNoErrors();

        Notification::assertCount(1);

        Notification::assertSentTo(
            $user,
            DetailedNotification::class,
        );
    }

    public function test_posts_ok_for_authenticated_user(): void
    {
        Notification::fake();

        $user = User::factory()->create(['has_completed_profile' => true]);
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->post(route('web.space-calculator.outputs.detailed.post', $inputs))
            ->assertRedirect(route('web.space-calculator.outputs.detailed.post', $inputs))
            ->assertSessionHasNoErrors();

        Notification::assertCount(1);

        Notification::assertSentTo(
            $user,
            DetailedNotification::class,
        );
    }

    public function test_redirect_for_guest_with_incomplete_profile(): void
    {
        Notification::fake();

        $user = User::factory()->create(['has_completed_profile' => false]);
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->post(route('web.space-calculator.outputs.detailed.post', $inputs))
            ->assertRedirect(route('web.space-calculator.outputs.index', $inputs))
            ->assertSessionHasNoErrors();

        Notification::assertCount(0);
    }

    public function test_redirect_for_guest_before_user_set_up(): void
    {
        Notification::fake();

        $inputs = SpaceCalculatorInput::factory()->create();

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->post(route('web.space-calculator.outputs.detailed.post', $inputs))
            ->assertRedirect(route('web.space-calculator.outputs.index', $inputs))
            ->assertSessionHasNoErrors();

        Notification::assertCount(0);
    }

    public function test_redirect_for_guest_without_session(): void
    {
        Notification::fake();

        $user = User::factory()->create(['has_completed_profile' => true]);
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->post(route('web.space-calculator.outputs.detailed.post', $inputs))
            ->assertRedirect(route('web.space-calculator.index'))
            ->assertSessionHasNoErrors();

        Notification::assertCount(0);
    }

    public function test_redirect_for_guest_with_different_uuid_in_session(): void
    {
        Notification::fake();

        $user = User::factory()->create(['has_completed_profile' => true]);
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->withSession([config('widgets.space-calculator.input-session-key') => $this->faker->uuid])
            ->post(route('web.space-calculator.outputs.detailed.post', $inputs))
            ->assertRedirect(route('web.space-calculator.index'))
            ->assertSessionHasNoErrors();

        Notification::assertCount(0);
    }

    public function test_redirect_for_authenticated_user_with_incomplete_profile(): void
    {
        Notification::fake();

        $user = User::factory()->create(['has_completed_profile' => false]);
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->authenticateUser($user);

        $this->withSession([config('widgets.space-calculator.input-session-key') => $inputs->uuid])
            ->post(route('web.space-calculator.outputs.detailed.post', $inputs))
            ->assertRedirect(route('web.portal.index'))
            ->assertSessionHasNoErrors();

        Notification::assertCount(0);
    }

    public function test_redirect_for_authenticated_user_if_enquiry_is_not_theirs(): void
    {
        Notification::fake();

        $user = User::factory()->create(['has_completed_profile' => true]);
        $enquiry = Enquiry::factory()->create(['user_id' => User::factory()->make()->id]);
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->authenticateUser($user);

        $this->post(route('web.space-calculator.outputs.detailed.post', $inputs))
            ->assertRedirect(route('web.portal.index'))
            ->assertSessionHasNoErrors();

        Notification::assertCount(0);
    }
}
