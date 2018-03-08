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
        switch ($age) {
            case ($age>=60):
                $price = 12;
                break;
            case ($age>=12):
                $price = 16;
                break;
            case ($age>=4):
                $price = 8;
                break;
            default:
                $price = 0;
        }
        if ($price>10 && $reducPrice) {
            $price = 10;
        }
        return $price;
    }
}