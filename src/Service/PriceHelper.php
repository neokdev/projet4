<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 07/03/2018
 * Time: 13:55
 */

namespace App\Service;


use DateTime;

class PriceHelper
{
    /**
     * @var DateHelper
     */
    private $helper;

    /**
     * PriceHelper constructor.
     * @param DateHelper $helper
     */
    public function __construct(DateHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @param DateTime $birthdate
     * @param null $reducPrice
     * @return int|null
     */
    public function calculatePrice(DateTime $birthdate, $reducPrice = null):? int
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