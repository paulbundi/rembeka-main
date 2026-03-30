<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckOutRequest extends FormRequest
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
            'password' => 'nullable',
            'phone' => ['required', 'unique:users'],
            'account_type' => 'nullable',
            'email' =>  ['required', 'unique:users'],
            'status' => 'nullable',
            'lat_long' => 'nullable',
            'name'=> ['required'],
            'lat_long'=> ['nullable'],
            'appartment'=> ['nullable'],
            'floor'=> ['nullable'],
            'room'=> ['nullable'],

        ];

        if (auth()->check()) {
            $rules = [];
        }

        return $rules;
    }
}
