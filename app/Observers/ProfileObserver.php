<?php

namespace App\Observers;

use App\Models\Profile;
use App\Models\User;

class ProfileObserver
{
    public function created(Profile $profile)
    {
        if (isset($profile->email)) {
            $user = User::create([
                'email'         => $profile->email,
                'password'      => bcrypt($profile->password),
                'role_id'       => \App\Enums\UserRole::USER
            ]);

            $profile->update([
                'password'      => null,
                'user_id'       => $user->id
            ]);
        }
    }
}
