<?php

namespace App\Rules;

use App\Helpers\WithdrawCharges;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class ValidateWithdrawAmount implements Rule
{
    /**
     * Safaricom charges.
     */
    protected $charges;
    /**
     * Amount to withdraw
     */
    protected $value;

    /**
     * @var int
     */
    protected $userId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($userId = null)
    {
        $this->userId = $userId;
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
        $this->value =  $value;

        $this->charges = WithdrawCharges::getCharge($value);

        if (!$this->userId) {
            $this->userId = auth()->id();
        }

        $user = User::where('id', $this->userId)->first();

        $availableAmount = $user->wallet - $this->charges;

        if ($value < 50 || $availableAmount < $value) {
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
        $message = 'Insufficent amount in the wallet. You need Ksh '.$this->charges .' for the transaction cost.';
        if ($this->value < 50) {
            $message =  'You can only withdraw a minimum of Ksh 50.';
        }

        return $message;
    }
}
