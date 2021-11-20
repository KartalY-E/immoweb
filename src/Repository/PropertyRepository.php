<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    public function propertiesFilter($price, $bedroom, $bathroom, $city, $propertyType)
    {
        $qb = $this->createQueryBuilder('p')
            ->andWhere('p.propertyType = :propertyType')
            ->orderBy('p.id', 'ASC')
            ->setParameter('propertyType', $propertyType);
        // ->setMaxResults(10);

        if ($price != "") {
            $qb->setParameter('price', $price);
            $qb->andWhere('p.price <= :price');
        }

        if ($bedroom == '4') {
            $qb->setParameter('bedroom', $bedroom);
            $qb->andWhere('p.bedroom >= :bedroom');
        } elseif ($bedroom != 0) {
            $qb->setParameter('bedroom', $bedroom);
            $qb->andWhere('p.bedroom = :bedroom');
        }

        if ($bathroom == 4) {
            $qb->setParameter('bathroom', $bathroom);
            $qb->andWhere('p.bathroom >= :bathroom');
        } elseif ($bathroom != 0) {
            $qb->setParameter('bathroom', $bathroom);
            $qb->andWhere('p.bathroom = :bathroom');
        }

        if ($city != 0) {
            $qb->setParameter('city', $city);
            $qb->andWhere('p.city = :city');
        }

        $query = $qb->getQuery();
        
        return $query->execute();
    }

    public function randomProperty($count)
    {
        return $this->createQueryBuilder('p')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
