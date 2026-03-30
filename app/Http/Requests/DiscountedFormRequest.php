<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountedFormRequest extends FormRequest
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
            'product_id' => ['required', 'unique:discounteds,deleted_at,NULL'],
            'discount_type' => 'required',
            'discount_amount' => 'required',
        ];

        if (request()->method() != 'POST') {
            $productId =  $this->route('discounted');
            $rules = array_merge($rules, [
                'product_id' => ['required', 'unique:discounteds,product_id,'.$productId.',id,deleted_at,NULL']
            ]);
        }

        return $rules;
    }
}
