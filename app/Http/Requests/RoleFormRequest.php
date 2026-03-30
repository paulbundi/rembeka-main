<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleFormRequest extends FormRequest
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
            'title' => 'required|unique:roles',
            'permissions' => 'required',
            'description' => 'nullable',
            'organization_id' => 'nullable',
        ];

        if (request()->method() != 'post') {
            $rules = array_merge($rules, [
              'title' => 'required',
            ]);
        }

        return $rules;
    }
}
