<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 28/02/2018
 * Time: 14:26
 */

namespace App\Service;


use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DateHelper
{
    CONST TIMEZONE = 'Europe/Paris';
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function getActualDatetime():\DateTime
    {
        date_default_timezone_set(self::TIMEZONE);
        return new \DateTime();
    }

    public function getSelectedDate():\DateTime
    {
        return $this->session->get('order')->getDate();
    }
}