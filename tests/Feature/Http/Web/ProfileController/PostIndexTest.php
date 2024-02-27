<?php

namespace Feature\Http\Web\ProfileController;

use App\Actions\Users\UpdateProfileAction;
use App\Models\User;
use Mockery;
use Propaganistas\LaravelPhone\PhoneNumber;
use Tests\TestCase;

class PostIndexTest extends TestCase
{
    public function test_can_post_to_update_profile(): void
    {
        $user = User::factory()->create();

        $this->authenticateUser($user);

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

        $this->post(route('web.profile.index.post'), [
            'first_name' => 'Liam',
            'last_name' => 'Gallagher',
            'company_name' => 'Oasis Co',
            'phone' => new PhoneNumber('+447787878787', null),
            'marketing_opt_in' => true,
        ])
            ->assertRedirect(route('web.portal.index'))
            ->assertSessionHasNoErrors();
    }

    public function test_can_post_to_update_profile_of_user_with_incomplete_profile(): void
    {
        $user = User::factory()->create(['has_completed_profile' => false]);

        $this->authenticateUser($user);

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

        $this->post(route('web.profile.index.post'), [
            'first_name' => 'Liam',
            'last_name' => 'Gallagher',
            'company_name' => 'Oasis Co',
            'phone' => new PhoneNumber('+447787878787', null),
            'marketing_opt_in' => true,
        ])
            ->assertRedirect(route('web.portal.index'))
            ->assertSessionHasNoErrors();
    }

    public function test_guest_is_redirected(): void
    {
        $this->assertGuest();

        UpdateProfileAction::shouldNotRun();

        $this->post(route('web.profile.index.post'), [
            'first_name' => 'Liam',
            'last_name' => 'Gallagher',
            'company_name' => 'Oasis Co',
            'phone' => new PhoneNumber('+447787878787', null),
            'marketing_opt_in' => true,
        ])
            ->assertRedirect();
    }

    public function test_required_fields(): void
    {
        $this->authenticateUser();

        UpdateProfileAction::shouldNotRun();

        $this->post(route('web.profile.index.post'), [
            //
        ])
            ->assertRedirect()
            ->assertSessionHasErrors([
                'first_name',
                'last_name',
            ]);
    }

    public function test_other_errors(): void
    {
        $this->authenticateUser();

        UpdateProfileAction::shouldNotRun();

        $this->post(route('web.profile.index.post'), [
            'first_name' => 'Liam',
            'last_name' => 'Gallagher',
            'company_name' => 'Oasis Co',
            'phone' => 'This is a string',
            'marketing_opt_in' => 'true',
        ])
            ->assertRedirect()
            ->assertSessionHasErrors([
                'phone',
                'marketing_opt_in'
            ]);
    }
}
