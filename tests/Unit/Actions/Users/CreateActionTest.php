<?php

namespace Tests\Unit\Actions\Users;

use App\Actions\Users\CreateAction;
use App\Models\User;
use Tests\TestCase;

class CreateActionTest extends TestCase
{
    public function test_user_is_created_and_returned(): void
    {
        $this->assertEquals(0, User::query()->count());

        $user = CreateAction::run('test@widgets.co.uk');

        $this->assertEquals(1, User::query()->count());

        $this->assertEquals('test@widgets.co.uk', $user->email);
        $this->assertEquals('Test', $user->first_name);
        $this->assertEquals('', $user->last_name);
        $this->assertFalse($user->marketing_opt_in);
        $this->assertFalse($user->has_completed_profile);
        $this->assertNull($user->company);
        $this->assertNull($user->phone);
    }

    public function test_user_is_created_and_returned_with_last_name_filled_from_email(): void
    {
        $this->assertEquals(0, User::query()->count());

        $user = CreateAction::run('test.person@widgets.co.uk');

        $this->assertEquals(1, User::query()->count());

        $this->assertEquals('test.person@widgets.co.uk', $user->email);
        $this->assertEquals('Test', $user->first_name);
        $this->assertEquals('Person', $user->last_name);
    }
}
