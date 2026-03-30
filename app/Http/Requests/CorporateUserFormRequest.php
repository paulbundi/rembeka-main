<?php

namespace App\Http\Requests;

use App\Rules\UnqiueCorporateUser;
use Illuminate\Foundation\Http\FormRequest;

class CorporateUserFormRequest extends FormRequest
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
            'corporate_id' => 'required',
            'user_id' => ['required', new UnqiueCorporateUser(request()->get('corporate_id'))],
            'spend_limit' => 'nullable',
            'limit_period' => 'nullable',
            'limit_status' => 'nullable',
        ];
    }
}
