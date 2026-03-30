<?php

namespace App\Observers;

use App\Models\User;
use Carbon\Carbon;

class UserObserver
{
    /**
     * Listen for created user account.
     *
     * @param User $user
     *
     * @return void
     */
    public function created(User $user)
    {
        if ($user->account_type == User::TYPE_CORPORATE) {
            $user->account_no = 'C'.$user->id.'/'.Carbon::now()->format('m/y');
            $user->rating = 5;
            $user->save();
        } else {
            $user->rating = 5;
            $user->save();
        }
    }
}
