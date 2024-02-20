<?php

namespace Tests\Unit\Actions\Enquiries;

use App\Actions\Enquiries\AddContactDetailsAction;
use App\Models\Enquiry;
use Tests\TestCase;

class AddFullDetailsActionTest extends TestCase
{
    public function test_enquiry_is_attached_to_a_user(): void
    {
        $enquiry = Enquiry::factory()->create();

        AddContactDetailsAction::run(
            $enquiry,
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            true
        );

        $enquiry->refresh();
        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', $enquiry->message);
        $this->assertTrue($enquiry->can_contact);
    }
}
