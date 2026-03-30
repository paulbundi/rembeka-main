<?php

namespace App\Observers;

use App\Models\Provider;
use App\Models\User;
use App\Notifications\ProviderAccountCreated;
use Illuminate\Support\Facades\Password;

class ProviderObserver
{
    /**
     * Listen for created events.
     * 
     * @param Provider $provider
     *
     * @return void
     */
    public function created(Provider $provider)
    {
        $provider->slug = $provider->first_name.'-'.$provider->first_name.'-'.$provider->id;
        $provider->save();

        $user =  User::where('email', $provider->email)->first();

        if (!$user) {
            $user = User::create([
                'first_name' => $provider->first_name,
                'last_name' => $provider->last_name,
                'email' => $provider->email,
                'phone' => $provider->phone,
                'status' => User::STATUS_ACTIVE,
                'organization_id' => $provider->id,
                'account_type' => User::TYPE_PROVIDER,
            ]);
        }

        // $user->notify(new ProviderAccountCreated());

        // if ($user->wasRecentlyCreated) {
        //     Password::sendResetLink([
        //        'email' => $user->email
        //     ]);
        // }
    }
}
