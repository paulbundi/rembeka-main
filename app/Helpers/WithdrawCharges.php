<?php

namespace App\Helpers;

class WithdrawCharges
{
    protected static $ranges = [
        ['range' => 100, 'charge'=> 0],
        ['range' => 1500, 'charge'=> 5],
        ['range' => 5000, 'charge'=> 8],
        ['range' => 20000, 'charge'=> 10],
        ['range' =>20001,  'charge'=> 12],
    ];

    /**
     * Get Charges.
     *
     * @param any $amount
     *
     * @return int
     */
    public static function getCharge($amount): int
    {
        $range = collect(self::$ranges)->first(function ($item, $key) use ($amount) {
            if ($item['range'] >= $amount) {
                return true;
            }
        });
        if ($range == null) {
            $charges = end(static::$ranges);

            return $charges['charge'];
        }

        return $range['charge'];
    }
}
