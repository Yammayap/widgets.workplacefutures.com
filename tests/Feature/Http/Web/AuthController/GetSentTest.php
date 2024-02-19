<?php

namespace Feature\Http\Web\AuthController;

use App\Models\User;
use Tests\TestCase;

class GetSentTest extends TestCase
{
    public function test_can_access_route_as_guest(): void
    {
        $this->get(route('web.auth.sent'))
            ->assertOk()
            ->assertViewIs('web.auth.sent')
            ->assertSeeTextInOrder([
                'sent a magic link to your email address.',
                'Please click this link to sign in to your account.',
                'The link will expire in ' . config('widgets.magic-links.expiry-minutes') . ' minutes.',
                'Please check your email now.',
            ]);
    }

    public function test_can_access_route_as_auth_user(): void
    {
        $user = User::factory()->create();

        $this->withSession(['auth-sent-user' => $user])
            ->get(route('web.auth.sent'))
            ->assertOk()
            ->assertViewIs('web.auth.sent')
            ->assertSeeTextInOrder([
                'sent a magic link to ' . $user->email . '.',
                'Please click this link to sign in to your account.',
                'The link will expire in ' . config('widgets.magic-links.expiry-minutes') . ' minutes.',
                'Please check your email now.',
            ]);
    }
}
