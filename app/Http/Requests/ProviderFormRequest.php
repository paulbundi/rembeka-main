<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProviderFormRequest extends FormRequest
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
            'email' => ['required', 'unique:providers'],
            'phone' => ['required', 'unique:providers'],
            'location_id' => ['required'],
            'provider_styles' => 'required',
            'national_id' => 'required',
            'kra_pin' => 'required',
            'address' => 'required',
            'assign_service_by' => 'nullable',
            'short_description' => 'nullable',
            'status' => 'nullable',
            'published' => 'nullable',
        ];

        if (request()->method() !== 'POST') {
            $rules =  array_merge($rules, [
                'email' => ['required', 'unique:providers,email,'.request()->get('id')],
                'phone' => ['required', 'unique:providers,phone,'.request()->get('id')],
                'provider_styles' => 'nullable',
                'location_id' => 'nullable',
            ]);
        }

        return $rules;
    }
}
