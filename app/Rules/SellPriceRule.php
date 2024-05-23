<?php

namespace App\Rules;

use App\Helpers\PriceRuleHelper;
use Illuminate\Contracts\Validation\Rule;

class SellPriceRule implements Rule
{
    public $energy_id;

    public function __construct($param)
    {
        $this->energy_id = $param;
    }

    public function passes($attribute, $value)
    {
        if (PriceRuleHelper::isSellPriceValid($this->energy_id, $value)) {
            return true;
        }
        return false;
    }

    public function message()
    {
        return 'Your price should be between +/-10% of Latest Market Price.';
    }
}