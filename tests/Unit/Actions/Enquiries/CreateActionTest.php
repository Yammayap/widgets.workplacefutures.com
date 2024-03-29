<?php

namespace Tests\Unit\Actions\Enquiries;

use App\Actions\Enquiries\CreateAction;
use App\Enums\Tenant;
use App\Enums\Widget;
use App\Models\Enquiry;
use App\Models\User;
use Tests\TestCase;

class CreateActionTest extends TestCase
{
    public function test_enquiry_is_created_and_returned(): void
    {
        $this->assertEquals(0, Enquiry::count());

        /**
         * @var Enquiry $enquiry
         */
        $enquiry = CreateAction::run(
            Tenant::WFG,
            Widget::SPACE_CALCULATOR,
            null,
            false,
            null,
        );

        $this->assertEquals(1, Enquiry::count());

        $this->assertNull($enquiry->user_id);
        $this->assertEquals(Tenant::WFG, $enquiry->tenant);
        $this->assertEquals(Widget::SPACE_CALCULATOR, $enquiry->widget);
        $this->assertNull($enquiry->message);
        $this->assertFalse($enquiry->can_contact);
    }

    public function test_enquiry_is_created_and_returned_for_auth_user(): void
    {
        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();

        $this->assertEquals(0, Enquiry::count());

        /**
         * @var Enquiry $enquiry
         */
        $enquiry = CreateAction::run(
            Tenant::WFG,
            Widget::SPACE_CALCULATOR,
            null,
            false,
            $user_2,
        );

        $this->assertEquals(1, Enquiry::count());
        $this->assertEquals($user_2->id, $enquiry->user_id);
    }

    public function test_enquiry_is_created_and_returned_with_extra_optional_fields(): void
    {
        $this->assertEquals(0, Enquiry::count());

        /**
         * @var Enquiry $enquiry
         */
        $enquiry = CreateAction::run(
            Tenant::WFG,
            Widget::SPACE_CALCULATOR,
            'Lorem ipsum dolor sit amet',
            true,
            null,
        );

        $this->assertEquals(1, Enquiry::count());

        $this->assertNull($enquiry->user_id);
        $this->assertEquals(Tenant::WFG, $enquiry->tenant);
        $this->assertEquals(Widget::SPACE_CALCULATOR, $enquiry->widget);
        $this->assertEquals('Lorem ipsum dolor sit amet', $enquiry->message);
        $this->assertTrue($enquiry->can_contact);
    }
}
