<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ColorFormRequest extends FormRequest
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
        $colorId = $this->route('color') ?? $this->route('id');
        if (is_object($colorId)) {
            $colorId = $colorId->id ?? null;
        }

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('colors', 'name')->ignore($colorId),
            ],
            'slug' => 'nullable|string|max:100',
            'hex_code' => 'nullable|string|max:20',
            'display_type' => 'nullable|in:swatch,pill',
        ];
    }
}
