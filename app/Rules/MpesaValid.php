<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Njenga55\ServiceProvider\Facades\MobileProvider;

class MpesaValid implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            if (MobileProvider::getProvider(request()->get($attribute)) == 'Safaricom') {
                return true;
            }

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please provide a valid mobile number.';
    }
}
