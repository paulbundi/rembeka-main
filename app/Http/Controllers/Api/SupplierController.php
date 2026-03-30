<?php

namespace App\Http\Controllers\Api;

use App\Models\Supplier;
use App\Models\User;
use App\Notifications\SupplierAccountCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class SupplierController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Supplier::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'products', 'productPricings.product', 'locations',
            'profile.attachments.media', 'orders', 'user',
        ];
    }

    /**
     * @param Request $request
     *
     * @return void
     */
    public function postStore(Request $request)
    {
        if ($this->model->type == Supplier::TYPE_INDIVIDUAL && !$this->model->user_id) {
            if (User::where('email', $this->model->email)
                ->orWhere('phone', $this->model->phone)->exists()) {
                return;
            } else {
                $data = $request->all();

                $data['password'] = Hash::make(Str::random(24));
                $data['account_type'] = User::TYPE_SUPPLIER;
                $user = User::create($data);

                if ($user) {
                    $this->model->user_id = $user->id;
                    $this->model->save();

                    Password::sendResetLink([
                        'email' => $user->eamil,
                    ]);

                    $user->notify(new SupplierAccountCreated);
                }
            }
        }
    }
}
