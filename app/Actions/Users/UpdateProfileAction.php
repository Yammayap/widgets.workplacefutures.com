<?php

namespace App\Actions\Users;

use App\Models\User;
use Lorisleiva\Actions\Concerns\AsFake;
use Lorisleiva\Actions\Concerns\AsObject;
use Propaganistas\LaravelPhone\PhoneNumber;

class UpdateProfileAction
{
    use AsFake;
    use AsObject;

    /**
     * @param User $user
     * @param string $firstName
     * @param string $lastName
     * @param string|null $companyName
     * @param PhoneNumber|null $phone
     * @param bool $marketingOptIn
     * @return void
     */
    public function handle(
        User $user,
        string $firstName,
        string $lastName,
        ?string $companyName,
        ?PhoneNumber $phone,
        bool $marketingOptIn,
    ): void {
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->company_name = $companyName;
        $user->phone = $phone;
        $user->marketing_opt_in = $marketingOptIn;
        $user->has_completed_profile = true;
        $user->save();
    }
}
