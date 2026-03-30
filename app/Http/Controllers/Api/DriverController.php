<?php

namespace App\Http\Controllers\Api;

use App\Models\Driver;
use App\Models\Supplier;
use App\Models\User;
use App\Notifications\DriverAccountCreated;
use App\Notifications\SupplierAccountCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class DriverController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Driver::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'orders', 'user',
        ];
    }

    /**
     * @param Request $request
     *
     * @return void
     */
    public function postStore(Request $request)
    {
            if (User::where('email', $this->model->email)
                ->orWhere('phone', $this->model->phone)->exists()) {
                return;
            } else {
                $data = $request->all();

                $data['password'] = Hash::make(Str::random(24));
                $data['account_type'] = User::TYPE_DRIVER;
                $user = User::create($data);

                if ($user) {
                    $this->model->user_id = $user->id;
                    $this->model->save();

                    Password::sendResetLink([
                        'email' => $user->eamil,
                    ]);

                    $user->notify(new DriverAccountCreated);
                }
            }
    }
}
