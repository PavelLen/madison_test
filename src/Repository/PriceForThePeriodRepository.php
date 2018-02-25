<?php

namespace App\Repository;

use App\Entity\PriceForThePeriod;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PriceForThePeriod|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriceForThePeriod|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriceForThePeriod[]    findAll()
 * @method PriceForThePeriod[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceForThePeriodRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PriceForThePeriod::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.something = :value')->setParameter('value', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
