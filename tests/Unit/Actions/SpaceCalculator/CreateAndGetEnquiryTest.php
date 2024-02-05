<?php

namespace Tests\Unit\Actions\SpaceCalculator;

use App\Actions\SpaceCalculator\CreateAndGetEnquiryAction;
use App\Enums\Tenant;
use App\Enums\Widget;
use App\Models\Enquiry;
use App\Services\TenantManager\TenantManager;
use Tests\TestCase;

class CreateAndGetEnquiryTest extends TestCase
{
    public function test_enquiry_is_created_and_returned(): void
    {
        $tenantManager = app()->make(TenantManager::class);
        $tenantManager->setTenantFromRequest(request());

        $this->assertEquals(0, Enquiry::count());

        /**
         * @var Enquiry $enquiry
         */
        $enquiry = CreateAndGetEnquiryAction::run();

        $this->assertEquals(1, Enquiry::count());

        $this->assertEquals(Tenant::WFG, $enquiry->tenant);
        $this->assertEquals(Widget::SPACE_CALCULATOR, $enquiry->widget);
        $this->assertFalse($enquiry->can_contact);
    }
}