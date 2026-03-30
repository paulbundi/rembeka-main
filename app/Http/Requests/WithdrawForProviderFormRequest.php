<?php

namespace App\Http\Requests;

use App\Rules\ValidateWithdrawAmount;
use Illuminate\Foundation\Http\FormRequest;

class WithdrawForProviderFormRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'provider_id' =>'required|integer',
            'amount' => ['required', new ValidateWithdrawAmount(request()->get('user_id'))],
        ];
    }
}
