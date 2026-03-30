<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductPricingFormRequest extends FormRequest
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
            'product_id' => 'required',
            'supplier_id' => 'required',
            'productPricing' => 'required',
        ];

        if (request()->method() != 'POST') {
            $rules =  array_merge($rules, [
                'productPricing' => 'nullable',
                'size' => 'required',
                'unit_id'=> 'required',
                'supplier_price' => 'required',
                'mark_up_percentage' => 'required',
                'amount' => 'required',
                'configs' => 'nullable',
                'status' => 'nullable',
                're_order_level'=> 'nullable',
            ]);
        }

        return $rules;
    }
}
