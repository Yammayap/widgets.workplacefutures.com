<?php

namespace App\Actions\Enquiries;

use App\Models\Enquiry;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsFake;
use Lorisleiva\Actions\Concerns\AsObject;

class AttachToUserAction
{
    use AsFake;
    use AsObject;

    /**
     * @param Enquiry $enquiry
     * @param User $user
     * @return void
     */
    public function handle(Enquiry $enquiry, User $user): void
    {
        $enquiry->user()->associate($user);
        $enquiry->save();
    }
}
