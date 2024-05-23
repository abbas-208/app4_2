<?php

namespace App\Helpers;

use App\Models\Energy;

class PriceRuleHelper
{
    public static function getPercentValue($value, $percent) {
        return (($value * $percent) / 100) ;
    }

    public static function isSellPriceValid($energy_id, $price) {
        $marketPrice = Energy::where('id', $energy_id)->get(['market_price'])->toArray()[0]["market_price"];
        $percentValue = PriceRuleHelper::getPercentValue($marketPrice, 10);
        if (($marketPrice - $percentValue) <= $price && ($marketPrice + $percentValue) >= $price) {
            return true;
        }
        return false;
    }

    public static function getLocation($num) {
        return ($num == 2 || $num == 5)? "City" : "Sandy Bay";
    }
}

