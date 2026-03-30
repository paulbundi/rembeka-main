<?php

namespace App\Rules;

use App\Models\Product;
use App\Models\ProviderPricing;
use Illuminate\Contracts\Validation\Rule;

class RequireIfService implements Rule
{
    /**
     * Validating attribute.
     *
     * @var string
     */
    protected $attribute;

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
        $this->attribute = $attribute;

        // $product = ProviderPricing::with(['product'])
        //     ->findOrFail(request()->get('product_id'));
        // if ($product->product->type == Product::TYPE_SERVICE && $value == null) {
        //     return false;
        // }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->attribute == 'date') {
            return 'Provider a date when you would like the service.';
        }

        return 'Provide a time slot.';
    }
}
