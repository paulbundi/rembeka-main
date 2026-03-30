<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertFormRequest extends FormRequest
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
        return [
            'name' => 'required',
            'call_to_action_url' => 'required',
            'call_to_action' => 'nullable',
            'type' => 'required',
            'product_id' => 'required_if:type,2',
            'status' => 'nullable',
            'audit' => 'nullable',
            'banner_image' => 'nullable',
        ];
    }
}
