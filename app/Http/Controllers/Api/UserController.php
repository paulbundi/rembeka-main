<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Notifications\WelcomeToRembeka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class UserController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return User::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'users', 'wishlist', 'store',
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postStore(Request $request)
    {
        if ($this->model->wasRecentlyCreated) {
            $this->model->notify(new WelcomeToRembeka);

            Password::sendResetLink([
                'email' => $this->model->email,
            ]);
        }
    }

    /**
     * send password  reset link
     *
     * @param int $id
     *
     * @return void
     */
    public function sendPasswordReset(int $id)
    {
        $user = User::findOrFail($id);

        Password::sendResetLink([
            'email' => $user->email,
        ]);

        return  response()->json();
    }
}
