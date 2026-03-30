<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnerFormRequest extends FormRequest
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
            'user_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'media_id' => 'nullable',
            'status' => 'nullable',
        ];

        if (request()->method() == 'POST') {
            $rules = array_merge($rules, [
                'media_id' => 'required',
            ]);
        }

        return $rules;
    }
}
