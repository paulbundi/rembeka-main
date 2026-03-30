<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InquiryFormRequest extends FormRequest
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
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'social_name' => 'nullable',
            'email' =>'nullable',
            'phone' => 'nullable',
            'channel_id' => 'required',
            'description' => 'required',
            'callback_date' => 'nullable',
            'status' => 'nullable',
            'user_id' => 'required',
            'product_id' => 'required',
            'assigned_id' => 'required',
        ];
    }
}
