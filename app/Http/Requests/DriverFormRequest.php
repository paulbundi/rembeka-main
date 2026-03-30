<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DriverFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'unique:drivers'],
            'phone' => ['required', 'unique:drivers'],
            'national_id' => 'required',
            'description' => 'nullable',
            'status' => 'nullable',
            'dl_no' => 'required',
            'dl_expiry_date' => 'required',
        ];

        if (request()->method() != 'POST') {
            $rules = array_merge($rules, [
                'email' => ['required', 'unique:drivers,email,'.request()->id],
                'phone' => ['required', 'unique:drivers,phone,'.request()->id],
            ]);
        }

        return $rules;
    }
}
