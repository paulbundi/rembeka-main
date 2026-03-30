<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderItemRequest extends FormRequest
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
            'order_id' => 'required',
            'provider_id' => 'required',
            'quantity' => 'required',
            'status' => 'required',
            'type' => 'required',
            'appointment_date' => 'required_if:type,2',
            'appointment_time' => 'required_if:type,2',
        ];
    }
}
