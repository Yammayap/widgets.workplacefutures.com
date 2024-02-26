<?php

namespace Feature\Http\Web\ProfileController;

use App\Models\User;
use Tests\TestCase;

class GetIndexTest extends TestCase
{
    public function test_page_loads_ok_forUser_with_complete_profile(): void
    {
        $user = User::factory()->create();

        $this->authenticateUser($user);

        $this->get(route('web.profile.index'))
            ->assertOk()
            ->assertViewIs('web.profile.index')
            ->assertSeeTextInOrder([
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

    /*
     * more to test
     *
     * with incomplete profile
     * guest gets redirected
     *
     */
}
