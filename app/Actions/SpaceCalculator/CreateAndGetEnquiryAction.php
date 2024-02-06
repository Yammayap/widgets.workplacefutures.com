<?php

namespace App\Actions\SpaceCalculator;

use App\Enums\Widget;
use App\Models\Enquiry;
use App\Services\TenantManager\TenantManager;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsFake;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateAndGetEnquiryAction
{
    use AsFake;
    use AsObject;

    /**
     * @param TenantManager $tenantManager
     */
    public function __construct(private readonly TenantManager $tenantManager)
    {
        //
    }

    /**
     * @return Enquiry
     */
    public function handle(): Enquiry
    {
        $enquiry = new Enquiry();
        if (!is_null(Auth::user())) {
            $enquiry->user_id = Auth::user()->id;
        }
        $enquiry->tenant = $this->tenantManager->getCurrentTenant();
        $enquiry->widget = Widget::SPACE_CALCULATOR;
        $enquiry->can_contact = false;
        $enquiry->save();

        return $enquiry;
    }
}
