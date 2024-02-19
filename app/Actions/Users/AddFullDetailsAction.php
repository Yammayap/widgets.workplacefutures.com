<?php

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsFake;
use Lorisleiva\Actions\Concerns\AsObject;
use Propaganistas\LaravelPhone\PhoneNumber;

class AddFullDetailsAction
{
    use AsFake;
    use AsObject;

    /**
     * @param User $user
     * @param string $firstName
     * @param string $lastName
     * @param string $companyName
     * @param string $phone
     * @param bool $marketingOptIn
     * @return void
     */
    public function handle(
        User $user,
        string $firstName,
        string $lastName,
        string $companyName,
        string $phone,
        bool $marketingOptIn,
    ): void {
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->company_name = $companyName;
        $user->phone = new PhoneNumber($phone, Str::startsWith($phone, '+') ? null : 'GB');
        $user->marketing_opt_in = $marketingOptIn;
        $user->has_completed_profile = true;
        $user->save();
    }
}
