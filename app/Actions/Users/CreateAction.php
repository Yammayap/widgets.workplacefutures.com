<?php

namespace App\Actions\Users;

use App\Models\User;
use Lorisleiva\Actions\Concerns\AsFake;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateAction
{
    use AsFake;
    use AsObject;

    public function handle(string $email): User
    {
        $user = new User();
        $user->email = $email;
        $user->marketing_opt_in = false;
        $user->has_completed_profile = false;
        $user->save();

        return $user;
    }
}
