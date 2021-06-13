<?php

namespace App\Repository;

use App\Entity\OfferVariation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OfferVariation|null find($id, $lockMode = null, $lockVersion = null)
 * @method OfferVariation|null findOneBy(array $criteria, array $orderBy = null)
 * @method OfferVariation[]    findAll()
 * @method OfferVariation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferVariationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OfferVariation::class);
    }

    // /**
    //  * @return OfferVariation[] Returns an array of OfferVariation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OfferVariation
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
