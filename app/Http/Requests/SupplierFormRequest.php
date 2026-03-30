<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierFormRequest extends FormRequest
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
            'type' => ['required'],
            'user_id' =>['nullable'],
            'name' => ['required_if:type,2'],
            'first_name' => ['required_if:type,1'],
            'last_name' => ['required_if:type,1'],
            'email' => ['required', 'unique:suppliers'],
            'phone' => ['required', 'unique:suppliers'],
            'national_id' => 'required_if:type,1',
            'kra_pin' => 'required',
            'address' => 'required',
            'description' => 'nullable',
            'status' => 'nullable',
        ];

        if (request()->method() != 'POST') {
            $rules = array_merge($rules, [
                'email' => ['required', 'unique:suppliers,email,'.request()->id],
                'phone' => ['required', 'unique:suppliers,phone,'.request()->id],
            ]);
        }

        return $rules;
    }
}
