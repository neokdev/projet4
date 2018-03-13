<?php

namespace App\Repository;

use App\Entity\TicketOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TicketOrderRepository extends ServiceEntityRepository
{
    /**
     * TicketOrderRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TicketOrder::class);
    }

    /**
     * @param \DateTime|null $date
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function ticketsForThisDate(\DateTime $date=null)
    {
        return $this->createQueryBuilder('ticket_order')
            ->select('COUNT(ticket_order.date)')
            ->where('ticket_order.date = :date')->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
