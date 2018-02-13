<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 09/02/2018
 * Time: 09:17
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class Wizard
{
    CONST CLOSED_DATE = [
        "01-05" => true,
        "01-11" => true,
        "25-12" => true
    ];
    CONST LIMIT_TIME = 14;
    CONST TIMEZONE = "Europe/Paris";

    /**
     * @param \DateTime $date
     * @return bool
     */
    public function dateIsValid(\DateTime $date): bool
    {
        if (!$this->isThuesday($date) && $this->isOpenDays($date)) {
            return true;
        }
        return false;
    }

    /**
     * @param \DateTime $date
     * @return bool
     */
//    public function isThuesday(\DateTime $date): bool
//    {
//        return date_format($date, "D") == "Tue";
//    }

    /**
     * @param \DateTime $date
     * @return bool
     */
    public function isOpenDays(\DateTime $date): bool
    {
        return !isset(Wizard::CLOSED_DATE[date_format($date, "d-m")]);
    }

    /**
     * @return bool
     */
    public function dayTicketsAvailable(): bool
    {
        date_default_timezone_set(Wizard::TIMEZONE);
        return Wizard::LIMIT_TIME >= date('H', (gettimeofday()['sec']));
    }
}