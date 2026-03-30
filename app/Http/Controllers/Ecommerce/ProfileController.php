<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordFormRequest;
use App\Http\Requests\UserFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('e-commerce.account.profile-edit');
    }

    /**
     * @param UserFormRequest $request
     *
     * @return void
     */
    public function update(UserFormRequest $request)
    {
        $data = $request->validated();

        User::where('id', auth()->id())
            ->update($data);

        return redirect()->route('profile.index')->with([
            'message' =>[
                'type' => 'success',
                'message' => 'Profile Updated',
            ],
        ]);
    }

    /**
     * update user password
     *
     * @param PasswordFormRequest $request
     *
     * @return void
     */
    public function passwordUpdate(PasswordFormRequest $request)
    {
        $data = $request->validated();

        User::where('id', auth()->id())->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.index')->with([
            'message' =>[
                'type' => 'success',
                'message' => 'Password Updated',
            ],
        ]);
    }
}
