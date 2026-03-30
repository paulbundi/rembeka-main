<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReferralcodeFormRequest extends FormRequest
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
            'id' => 'required',
            'code' => 'required',
            'description' => 'required',
            'selected' => 'required',
            'acquisition_cost' => 'nullable',
            'status' => 'nullable',
            'is_ambassador' => 'nullable',
            'referred_first_visit_discount' => 'nullable',
            'referred_second_visit_discount' => 'nullable',
            'ambassador_discount' => 'nullable',
            'max_users' => 'nullable',
            'used_count' => 'nullable',
        ];

        if (request()->method() == 'POST') {
            $rules = array_merge($rules, [
                'id' => 'nullable'
            ]);
        }

        return $rules;
    }
}
