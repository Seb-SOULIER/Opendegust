<?php

namespace App\Repository;

use App\Entity\Offer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Offer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offer[]    findAll()
 * @method Offer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offer::class);
    }

     /**
      * @return Offer[] Returns an array of Offer objects
      */
    public function findFilter(Request $request, array $localization): array
    {
        $query = $this->createQueryBuilder('o')
                ->select ('o','ov')
                ->join('o.offerVariations','ov')
                ->join('ov.calendars','c')
                ->join('o.categories','ca')
                ->join('o.contact','lo');

        if (!empty($request->query->get('price-min'))) {
            $query = $query
                ->andWhere('ov.price >= :price_min')
                ->setParameter('price_min', $request->query->get('price-min'));
        }

        if (!empty($request->query->get('price-max'))) {
            $query = $query
                ->andWhere('ov.price <= :price_max')
                ->setParameter('price_max', $request->query->get('price-max'));
        }

        if (!empty($request->query->get('language'))) {
            foreach ($request->query->get('language') as $language) {
                $query = $query
                    ->andWhere('o.language LIKE :language')
                    ->setParameter('language', '%'.$language.'%');
            }
        }

        if (!empty($request->query->get('dateStart'))) {
                $query = $query
                    ->andWhere('c.startAt >= :dateStart')
                    ->setParameter('dateStart', $request->query->get('dateStart'));
        }

        if (!empty($request->query->get('dateStop'))) {
            $query = $query
                ->andWhere('c.startAt <= :dateStop')
                ->setParameter('dateStop', $request->query->get('dateStop'));
        }

        if (!empty($request->query->get('category'))) {
            foreach ($request->query->get('category') as $category) {
                $query = $query
                    ->andWhere('ca.id = :category')
                    ->setParameter('category', $category);
            }
        }

//        $lat = $localization[0]['lat'];
//        $lon = $localization[0]['lon'];
//        $query->OrderBy(POW(('lo.longitude' - $lon),2) + POW(('lo.latitude' - $lat),2),'ASC');

        return $query->getQuery()->getResult();
    }

/*
    public function findOneBySomeField($value): ?Offer
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
