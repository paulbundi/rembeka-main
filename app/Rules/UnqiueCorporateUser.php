<?php

namespace App\Rules;

use App\Models\CorporateUser;
use Illuminate\Contracts\Validation\Rule;

class UnqiueCorporateUser implements Rule
{
    protected $corporateId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $corporateId)
    {
        $this->corporateId = $corporateId;
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
        return !CorporateUser::where('corporate_id', $this->corporateId)
            ->where('user_id', $value)
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'User is already attached to the corporate.';
    }
}
