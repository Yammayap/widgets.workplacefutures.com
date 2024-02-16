<?php

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsFake;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateAction
{
    use AsFake;
    use AsObject;

    public function handle(string $email): User
    {
        $user = new User();

        // todo: discuss - first name and last name are not null - is this ok?
        // This is getting the name from the email address, sometimes emails have dots so this could be used?
        /**
         * @var string $emailNames
         */
        $emailNames = strstr($email, '@', true);
        $name = explode('.', $emailNames);
        $user->first_name = ucfirst(Arr::get($name, 0));
        $user->last_name = ucfirst(Arr::get($name, 1, ''));

        $user->email = $email;
        $user->marketing_opt_in = false;
        $user->has_completed_profile = false;
        $user->save();

        return $user;
    }
}
