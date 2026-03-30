<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'organization_id' => 'nullable',
            'account_type' => 'nullable',
            'status' => 'nullable',
            'phone' => ['required', 'unique:users'],
            'email' => ['required', 'unique:users'],
            'store_id' => ['nullable'],
            'gender_id' => ['nullable'],
        ];

        if (auth()->check() && Route::currentRouteName() == 'users.update') {
            $rules = array_merge($rules, [
                'email' => ['required', 'unique:users,email,'.request()->id],
                'phone' => ['required', 'unique:users,phone,'.request()->id],
            ]);
        } elseif (auth()->check()) {
            $rules = array_merge($rules, [
                'email' => ['required', 'unique:users,email,'.auth()->id()],
                'phone' => ['required', 'unique:users,phone,'.auth()->id()],
            ]);
        }

        $rules = array_merge($rules, [
            'first_name' => 'excludeIf:account_type,'. User::TYPE_CORPORATE,
            'last_name' => 'excludeIf:account_type,'. User::TYPE_CORPORATE,
            'organization_name' =>'required_if:account_type,'. User::TYPE_CORPORATE,
        ]);

        return $rules;
    }
}
