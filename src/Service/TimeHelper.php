<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 01/03/2018
 * Time: 13:06
 */

namespace App\Service;


class TimeHelper
{
    /**
     * @var DateHelper
     */
    private $helper;

    public function __construct(DateHelper $helper)
    {
        $this->helper = $helper;
    }
    public function isTimeExceed(string $limit):bool
    {
        return ((date_format($this->helper->getActualDatetime(), "H:i")) >= $limit);
    }
}