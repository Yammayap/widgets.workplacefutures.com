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
        ?string $message,
        bool $canContact,
        ?User $user,
    ): Enquiry {
        $enquiry = new Enquiry();
        $enquiry->tenant = $tenant;
        $enquiry->widget = $widget;
        $enquiry->message = $message;
        $enquiry->can_contact = $canContact;
        if ($user) {
            $enquiry->user()->associate($user);
        }
        $enquiry->save();

        return $enquiry;
    }
}
