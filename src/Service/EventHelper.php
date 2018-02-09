<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 05/02/2018
 * Time: 16:43
 */

namespace App\Service;

use App\Repository\ProductsRepository;
use Symfony\Component\Validator\Constraints as Assert;

class EventHelper
{
    /**
     * @var ProductsRepository
     */
    private $productsRepository;

    /**
     * EventHelper constructor.
     * @param ProductsRepository $productsRepository
     */
    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    /**
     * @param \DateTime $date
     * @return bool
     * @Assert\IsFalse(message="Sorry, closed on Tuesdays")
     */
    public function isTuesday(\DateTime $date):bool
    {
       return date_format($date, 'D') === 'Tue';
    }

}