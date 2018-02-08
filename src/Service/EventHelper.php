<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 05/02/2018
 * Time: 16:43
 */

namespace App\Service;

use App\Repository\DatesRepository;

class EventHelper
{
    /**
     * @var DatesRepository
     */
    private $datesRepository;

    /**
     * EventHelper constructor.
     * @param DatesRepository $datesRepository
     */
    public function __construct(DatesRepository $datesRepository)
    {
        $this->datesRepository = $datesRepository;
    }

    public function checkValidDate(\DateTime $date)
    {
        $selectedDate =  $this->datesRepository->getDate($date);
        if (is_null($selectedDate)) {

        }

    }
}