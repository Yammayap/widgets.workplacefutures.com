<?php

namespace Feature\Http\Web\ProfileController;

use App\Models\User;
use Tests\TestCase;

class GetIndexTest extends TestCase
{
    public function test_page_loads_ok_for_user_with_complete_profile(): void
    {
        $user = User::factory()->create();

        $this->authenticateUser($user);

        $this->get(route('web.profile.index'))
            ->assertOk()
            ->assertViewIs('web.profile.index')
            ->assertSeeTextInOrder([
                'Update your profile',
                'First name *',
                'Last name *',
                'Email address',
                $user->email,
                'Company name',
                'Phone',
                'happy to receive marketing from Workplace Futures Group',
                'Save changes',
            ])
            ->assertDontSeeText('You must complete your profile before using this website');
    }

    public function test_page_loads_ok_for_user_with_incomplete_profile(): void
    {
        $user = User::factory()->create(['has_completed_profile' => false]);

        $this->authenticateUser($user);

        $this->get(route('web.profile.index'))
            ->assertOk()
            ->assertViewIs('web.profile.index')
            ->assertSeeText('You must complete your profile before using this website');
    }

    public function test_guest_is_redirected_away(): void
    {
        $this->assertGuest();

        $this->get(route('web.profile.index'))
            ->assertRedirect();
    }
}
