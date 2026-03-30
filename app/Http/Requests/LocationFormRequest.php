<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationFormRequest extends FormRequest
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
            'name' => 'required',
            'parent_id' => 'nullable',
            'status' => 'nullable',
            'aliases' => 'nullable',
        ];

        if (request()->method() != 'POST') {
            $rules = array_merge($rules, [
                'id' => 'required',
            ]);
        }

        return $rules;
    }
}
