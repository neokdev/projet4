<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 25/02/2018
 * Time: 22:50
 */

namespace App\Manager;

use App\Entity\TicketOrder;
use App\Repository\TicketOrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderManager
{
    /**
     * @var TicketOrder
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(
        TicketOrderRepository $repository,
        EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    public function setDate(TicketOrder $ticketOrder)
    {
        $this->repository->setDate($ticketOrder);
    }
}