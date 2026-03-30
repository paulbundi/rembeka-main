<?php

namespace App\Http\Requests;

use App\Rules\UniqueProduct;
use Illuminate\Foundation\Http\FormRequest;

class ProviderPricingFormRequest extends FormRequest
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
            'product_id' => ['required', new UniqueProduct],
            'category_id' => 'required',
            'provider_id' => 'required',
            'location_id' => 'nullable',
            'commission' => 'required',
            'cost_of_labour' => 'required',
            'service_pricing' => 'required',
        ];

        if (request()->method() != 'POST') {
            $rules = array_merge($rules, [
                'id' => 'required',
                'status' => 'nullable',
            ]);
        }

        return $rules;
    }
}
