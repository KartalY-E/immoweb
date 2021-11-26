<?php

namespace App\Repository;

use App\Entity\PropertyType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PropertyType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertyType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertyType[]    findAll()
 * @method PropertyType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertyType::class);
    }

    public function findOneByRandom()
    {
        $id_limits = $this->createQueryBuilder('PropertyType')
            ->select('MIN(PropertyType.id)', 'MAX(PropertyType.id)')
            ->getQuery()
            ->getOneOrNullResult();
        $random_possible_id = rand($id_limits[1], $id_limits[2]);

        return $this->createQueryBuilder('PropertyType')
            ->where('PropertyType.id >= :random_id')
            ->setParameter('random_id', $random_possible_id)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return PropertyType[] Returns an array of PropertyType objects
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
    public function findOneBySomeField($value): ?PropertyType
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
