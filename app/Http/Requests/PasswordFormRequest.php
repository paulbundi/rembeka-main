<?php

namespace App\Http\Requests;

use App\Rules\PasswordIscorrect;
use Illuminate\Foundation\Http\FormRequest;

class PasswordFormRequest extends FormRequest
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
            'old_password' => ['required', new PasswordIscorrect],
            'password' => ['required', 'min:6', 'confirmed'],
        ];
    }
}
