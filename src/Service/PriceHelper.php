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
    /**
     * @var DateHelper
     */
    private $helper;

    public function __construct(DateHelper $helper)
    {
        $this->helper = $helper;
    }

    public function calculatePrice(\DateTime $birthdate, $reducPrice = null):? int
    {
        date_default_timezone_set(DateHelper::TIMEZONE);
        $age = $birthdate->diff($this->helper->getSelectedDate())->y;
        dump(array_search($age, self::PRICE_PER_AGE));die();
        return array_search($age, self::PRICE_PER_AGE);
    }
}