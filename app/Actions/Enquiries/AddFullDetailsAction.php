<?php

namespace App\Actions\Enquiries;

use App\Models\Enquiry;
use Lorisleiva\Actions\Concerns\AsFake;
use Lorisleiva\Actions\Concerns\AsObject;

class AddFullDetailsAction
{
    use AsFake;
    use AsObject;

    /**
     * @param Enquiry $enquiry
     * @param string|null $message
     * @param bool $canContact
     * @return void
     */
    public function handle(Enquiry $enquiry, string|null $message = null, bool $canContact = false): void
    {
        $enquiry->message = $message;
        $enquiry->can_contact = $canContact;
        $enquiry->save();
    }
}
