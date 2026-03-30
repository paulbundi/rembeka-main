<?php

namespace App\Rules;

use App\Models\ProviderPricing;
use Illuminate\Contracts\Validation\Rule;

class UniqueProduct implements Rule
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
        if (request()->method() != 'POST') {
            $providerPricing = ProviderPricing::where('product_id', $value)
                ->where('provider_id', request()->get('provider_id'))
                ->first();

            if ($providerPricing && $providerPricing->id !== request()->get('id')) {
                return false;
            }

            return true;
        }

        $exists = ProviderPricing::where('product_id', $value)
            ->where('provider_id', request()->get('provider_id'))
            ->exists();
        if ($exists) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $message = 'The Product/Service is already listed under provider.';
        if (request()->method() != 'POST') {
            $message = 'Selected Product already Exists Under a different Pricing!';
        }

        return $message;
    }
}
