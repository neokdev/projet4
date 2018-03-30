<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 15/03/2018
 * Time: 12:26
 */
namespace App\Repository;

use App\Entity\Ticket;
use App\Entity\TicketOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class TicketRepository
 */
class TicketRepository extends ServiceEntityRepository
{
    /**
     * TicketRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    /**
     * @param TicketOrder $order
     * @param Ticket      $tickets
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(TicketOrder $order, $tickets)
    {
        /** @var Ticket $ticket */
        foreach ($tickets as $ticket) {
            $ticket->setTicketOrder($order);
            $this->getEntityManager()->persist($ticket);
        }
        $this->getEntityManager()->flush();
    }
}
