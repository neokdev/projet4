<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 28/02/2018
 * Time: 14:26
 */

namespace App\Service;


class DateHelper
{
    CONST TIMEZONE = 'Europe/Paris';

    public function getActualDatetime()
    {
        date_default_timezone_set(DateHelper::TIMEZONE);
        return new \DateTime();
    }
}