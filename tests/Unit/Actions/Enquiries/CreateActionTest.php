<?php

namespace Tests\Unit\Actions\Enquiries;

use App\Actions\Enquiries\CreateAction;
use App\Enums\Tenant;
use App\Enums\Widget;
use App\Models\Enquiry;
use App\Models\User;
use App\Services\TenantManager\TenantManager;
use Tests\TestCase;

class CreateActionTest extends TestCase
{
    public function test_enquiry_is_created_and_returned(): void
    {
        $tenantManager = app()->make(TenantManager::class);
        $tenantManager->setTenantFromRequest(request());

        $this->assertEquals(0, Enquiry::count());

        /**
         * @var Enquiry $enquiry
         */
        $enquiry = CreateAction::run(
            $tenantManager->getCurrentTenant(),
            Widget::SPACE_CALCULATOR,
            null
        );

        $this->assertEquals(1, Enquiry::count());

        $this->assertNull($enquiry->user_id);
        $this->assertEquals(Tenant::WFG, $enquiry->tenant);
        $this->assertEquals(Widget::SPACE_CALCULATOR, $enquiry->widget);
        $this->assertFalse($enquiry->can_contact);
    }

    public function test_enquiry_is_created_and_returned_for_auth_user(): void
    {
        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();

        $tenantManager = app()->make(TenantManager::class);
        $tenantManager->setTenantFromRequest(request());

        $this->assertEquals(0, Enquiry::count());

        /**
         * @var Enquiry $enquiry
         */
        $enquiry = CreateAction::run(
            $tenantManager->getCurrentTenant(),
            Widget::SPACE_CALCULATOR,
            $user_2,
        );

        $this->assertEquals(1, Enquiry::count());
        $this->assertEquals($user_2->id, $enquiry->user_id);
    }
}
