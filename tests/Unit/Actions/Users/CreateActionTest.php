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
        $this->assertNull($user->first_name);
        $this->assertNull($user->last_name);
        $this->assertFalse($user->marketing_opt_in);
        $this->assertFalse($user->has_completed_profile);
        $this->assertNull($user->company);
        $this->assertNull($user->phone);
    }
}
