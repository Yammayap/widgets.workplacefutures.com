<?php

namespace App\Actions\Enquiries;

use App\Enums\Tenant;
use App\Enums\Widget;
use App\Models\Enquiry;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsFake;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateAction
{
    use AsFake;
    use AsObject;

    /**
     * @param Tenant $tenant
     * @param Widget $widget
     * @param User|null $user
     * @param string|null $message
     * @param bool $canContact
     * @return Enquiry
     */
    public function handle(
        Tenant $tenant,
        Widget $widget,
        User $user = null,
        string|null $message = null,
        bool $canContact = false
    ): Enquiry {
        $enquiry = new Enquiry();
        if ($user) {
            $enquiry->user()->associate($user);
        }
        $enquiry->tenant = $tenant;
        $enquiry->widget = $widget;
        $enquiry->message = $message;
        $enquiry->can_contact = $canContact;
        $enquiry->save();

        return $enquiry;
    }
}
