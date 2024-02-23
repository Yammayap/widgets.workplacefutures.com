<?php

namespace Tests\Feature\Http\Web\AuthController;

use App\Actions\MagicLinks\SendAction;
use App\Models\User;
use Tests\TestCase;

class PostSignInTest extends TestCase
{
    public function test_can_post_as_guest(): void
    {
        $user = User::factory()->create();

        $this->assertGuest();

        SendAction::shouldRun()
            ->once()
            ->with(
                $this->mockArgModel($user),
                '127.0.0.1',
                route('web.portal.index'),
            );

        $this->post(route('web.auth.sign-in.post'), [
           'email' => $user->email,
        ])
            ->assertRedirect(route('web.auth.sent'))
            ->assertSessionHas('auth-sent-user'); // todo: discuss - asserting session = $user fails here?
    }

    public function test_cannot_post_as_authenticated_user(): void
    {
        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();

        $this->authenticateUser($user_1);

        SendAction::shouldNotRun();

        $this->post(route('web.auth.sign-in.post'), [
            'email' => $user_2->email,
        ])
            ->assertRedirect(route('web.home.index'))
            ->assertSessionMissing('auth-sent-user');
    }

    public function test_required_field(): void
    {
        User::factory()->create();

        $this->assertGuest();

        SendAction::shouldNotRun();

        $this->post(route('web.auth.sign-in.post'), [
            //
        ])
            ->assertRedirect(route('web.home.index'))
            ->assertSessionMissing('auth-sent-user');
    }

    public function test_email_must_be_valid(): void
    {
        User::factory()->create();

        $this->assertGuest();

        SendAction::shouldNotRun();

        $this->post(route('web.auth.sign-in.post'), [
            'email' => 'loremIpsum123'
        ])
            ->assertRedirect(route('web.home.index'))
            ->assertSessionMissing('auth-sent-user');
    }

    public function test_email_must_belong_to_existing_user(): void
    {
        User::factory()->create(['email' => 'liam@oasis.co.uk']);
        User::factory()->create(['email' => 'noel@oasis.co.uk']);
        User::factory()->create(['email' => 'andy@oasis.co.uk']);

        $this->assertGuest();

        SendAction::shouldNotRun();

        $this->post(route('web.auth.sign-in.post'), [
            'email' => 'damon@blur.co.uk'
        ])
            ->assertRedirect(route('web.home.index'))
            ->assertSessionMissing('auth-sent-user');
    }
}
