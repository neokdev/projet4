<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 09/02/2018
 * Time: 09:17
 */

namespace App\Service;


use App\Entity\Products;

class Wizard
{
    CONST TIMEZONE = 'Europe/Paris';
    CONST LIMIT_TIME = 14;

    public function dayTicketsAvailable(): bool
    {
        date_default_timezone_set(Wizard::TIMEZONE);
        return Wizard::LIMIT_TIME >= date('H', (gettimeofday()['sec']));
    }

    public function isToday(\DateTime $date):bool
    {
        return (date_format($date, "Y-m-d")) == (date("Y-m-d", time()));
    }

    public function currentDay()
    {
        return date('d-m-yy', time());
    }

    public function currentHour()
    {
        return date('H', time());
    }

    public function isTimeExceed($hour)
    {
        return $hour >= Wizard::LIMIT_TIME;
    }
    public function isDayTicketsPossible():bool
    {
        return !$this->isToday() && !$this->isTimeExceed();
    }

    public function halfdayTicketForced()
    {
        $products = new Products();
        date_default_timezone_set(Wizard::TIMEZONE);
        $productDatetime = $products->getDate();
        $productHour = date_format($productDatetime, 'H');

        return [
            $productDatetime,
            date("Y-m-d", time()),
            date_format($productDatetime, "Y-m-d"),
            $this->isToday($productDatetime),
        ];

//        if ($this->isToday($productDatetime) && $this->isTimeExceed($productHour)) {
//            return true;
//        }
//        return false;
    }
}