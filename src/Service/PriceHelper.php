<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 07/03/2018
 * Time: 13:55
 */

namespace App\Service;


class PriceHelper
{
    CONST PRICE_PER_AGE = [
        '<4' => 0,
        '>=4' => 8,
        '>=12' => 16,
        '>=60' => 12
    ];

    public static function calculatePrice($age, $reducPrice = null):? int
    {
        return array_search($age, self::PRICE_PER_AGE);
    }
}