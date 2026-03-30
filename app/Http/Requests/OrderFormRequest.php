<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderFormRequest extends FormRequest
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
            'user_id' =>'required',
            'notes' =>'required',
            'status' =>'nullable',
            'store_id' => 'nullable',
            'location_id' =>'required_if:store_id,null',
            'channel_id' =>'required',
            'order_items' => 'required',
            'inquiry_id' => 'nullable',
            'admin_id' => 'nullable',
            'has_transport_cost' => 'required',
            'delivery_amount' => 'nullable',
            'driver_id' => 'nullable',
        ];

        if(request()->method() != 'POST') {
            $rules =  array_merge($rules, [
                'notes' => 'nullable',
                'order_items' => 'nullable',
                'location_id' =>'nullable',
            ]);
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'location_id.required' => 'Please provide client address location'
        ];
    }
}
