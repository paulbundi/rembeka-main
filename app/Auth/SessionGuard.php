<?php

namespace App\Auth;

use Illuminate\Auth\SessionGuard as BaseSessionGuard;
use Illuminate\Contracts\Auth\Authenticatable;

class SessionGuard extends BaseSessionGuard
{
    /**
     * Log a user into the application without firing the Login event.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     */
    public function quietLogin(Authenticatable $user)
    {
        $this->updateSession($user->getAuthIdentifier());
        $this->setUser($user);
    }

    /**
     * Logout the user without updating remember_token
     * and without firing the Logout event.
     *
     * @param   void
     */
    public function quietLogout()
    {
        $this->clearUserDataFromStorage();
        $this->user = null;
        $this->loggedOut = true;
    }
}
