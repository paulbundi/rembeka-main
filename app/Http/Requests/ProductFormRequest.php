<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
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
            'name' => ['required'],
            'description' => ['required'],
            'keywords' => ['required'],
            'seo_title' => ['required'],
            'seo_description' => ['required'],
            'sku' => ['nullable'],
            'menu_id'=>['required'],
            'type' => ['required'],
            'age_groups' => 'nullable',
            'brand_id' => 'nullable',
            'constant_commission' => 'nullable',
            'is_published' => 'nullable',
            'status' => 'nullable',
        ];

        if (request()->get('type') == Product::TYPE_SERVICE) {
            $rules = array_merge($rules, [
                'duration_of_style' => 'nullable',
                'durability' => 'nullable',
                'product_used' => 'nullable',
                'cost_of_labour' => 'required',
                'commission' => 'required',
                'product_price' => 'required',
            ]);
        }

        return $rules;
    }
}
