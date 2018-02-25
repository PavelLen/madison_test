<?php

namespace App\Repository;

use App\Entity\ProductModification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductModification|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductModification|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductModification[]    findAll()
 * @method ProductModification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductModificationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductModification::class);
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
