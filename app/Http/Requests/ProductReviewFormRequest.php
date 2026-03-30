<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductReviewFormRequest extends FormRequest
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
            'product_id' => 'required' ,
            'rating' => 'required',
            'comment' => 'required',
        ];

        if (request()->method() != 'POST') {
            $rules =  array_merge($rules, [
                'is_visible' => 'required',
            ]);
        }

        return $rules;
    }
}
