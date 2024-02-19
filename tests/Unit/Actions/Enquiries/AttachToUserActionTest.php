<?php

namespace Tests\Unit\Actions\Enquiries;

use App\Actions\Enquiries\AttachToUserAction;
use App\Models\Enquiry;
use App\Models\User;
use Tests\TestCase;

class AttachToUserActionTest extends TestCase
{
    public function test_enquiry_is_attached_to_a_user(): void
    {
        $enquiry = Enquiry::factory()->create();
        $user = User::factory()->create();

        $this->assertNull($enquiry->user_id);

        AttachToUserAction::run($enquiry, $user);

        $this->assertEquals($user->id, $enquiry->user_id);
    }
}
