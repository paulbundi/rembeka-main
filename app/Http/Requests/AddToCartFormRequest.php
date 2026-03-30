<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Rules\RequireIfService;
use Illuminate\Foundation\Http\FormRequest;

class AddToCartFormRequest extends FormRequest
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
        $rules = [];

        if (request()->get('type') == Product::TYPE_PRODUCT) {
            $rules = [
                'quantity' => 'required',
                'pricing_id' => 'required',
                'type' => 'required',
                'color' => 'nullable',
            ];
        } else {
            $rules = [
                'product_id' => 'required',
                'provider_id' => 'required',
                'service_type' => 'nullable',
                'type' => 'required',
                'quantity' => 'required',
                'date' => [new RequireIfService()],
                'time' =>  [new RequireIfService()],
            ];
        }

        return $rules;
    }
}
