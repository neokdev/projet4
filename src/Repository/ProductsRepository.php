<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Products::class);
    }
    /**
     * @return array List of all dates objects in the database
     */
    public function getProductList()
    {
        return $this->findAll();
    }

    /**
     * @param \DateTime $date
     * @return array|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getDate(\DateTime $date=null): ?array
    {
        return $this->createQueryBuilder('products')
            ->select('products.date')
            ->where('products.date = :date')->setParameter('date', $date)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param \DateTime|null $date
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function ticketsForThisDate(\DateTime $date=null)
    {
        return $this->createQueryBuilder('products')
            ->select('COUNT(products.date)')
            ->where('products.date = :date')->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult();
    }
    /**
     * @param \DateTime $date
     * @return array|null
     * @throws \Doctrine\ORM\NonUniqueResultException

    public function getDateCount(\DateTime $date=null): ?int
    {
        $res = $this->createQueryBuilder('products')
            ->select('products.date')
            ->where('products.date = :date')->setParameter('date', $date)
            ->getQuery()
            ->getResult();

        $count = $res['count'];

        return $count;
    }
    */
}
