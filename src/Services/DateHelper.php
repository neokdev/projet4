<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 28/02/2018
 * Time: 14:26
 */

namespace App\Services;

use DateTime;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class DateHelper
 */
class DateHelper
{
    const TIMEZONE = 'Europe/Paris';

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * DateHelper constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @return DateTime
     */
    public function getActualDatetime(): DateTime
    {
        date_default_timezone_set(self::TIMEZONE);

        return new DateTime();
    }

    /**
     * @return DateTime
     */
    public function getSelectedDate(): DateTime
    {
        return $this->session->get('order')->getDate();
    }
}
