<?php

namespace App\Auth;

use App\Models\User;

class ImpersonationManager
{
    protected $auth;

    public function __construct()
    {
        $this->auth = app('auth');
    }

    /**
     * Get the impersonation session key.
     *
     * @return string
     */
    public function getSessionKey(): string
    {
        return 'imp823450f';
    }

    /**
     * Get the current impersonator id.
     *
     * @return int|null
     */
    public function getImpersonatorId(): ?int
    {
        return session($this->getSessionKey(), null);
    }

    /**
     * Check whether the current user is impersonating
     *
     * @return bool
     */
    public function isImpersonating() : bool
    {
        return session()->has($this->getSessionKey());
    }

    /**
     * Check whether the user can be impersonated
     *
     * @param User $user
     *
     * @return bool
     */
    public function canImpersonate(User $user) : bool
    {
        return $this->getImpersonatorId() !== $user->getKey() &&
            $user->getKey() !== $this->auth->id();
    }

    /**
     * Impersonate a user.
     *
     * @param User $impersonator
     * @param User $impersonate
     *
     * @return bool
     */
    public function impersonate(User $impersonator, User $impersonate): bool
    {
        if (! $this->canImpersonate($impersonate)) {
            return false;
        }

        try {
            session()->put($this->getSessionKey(), $impersonator->getKey());
            $this->auth->quietLogout();
            $this->auth->quietLogin($impersonate);
        } catch (\Exception $e) {
            dd($e);
            unset($e);

            return false;
        }

        return true;
    }

    /**
     * Exit the impersonation.
     *
     * @return bool
     */
    public function exit(): bool
    {
        if (!$this->isImpersonating()) {
            return false;
        }

        try {
            $impersonator = User::find($this->getImpersonatorId());
            $this->auth->quietLogout();
            $this->auth->quietLogin($impersonator);

            $this->clear();
        } catch (\Exception $e) {
            unset($e);

            return false;
        }

        return true;
    }

    /**
     * Clear the impersonation information
     */
    public function clear()
    {
        session()->forget($this->getSessionKey());
    }
}
