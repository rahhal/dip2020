<?php

namespace App\Repository;

use App\Entity\LineMeal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LineMeal|null find($id, $lockMode = null, $lockVersion = null)
 * @method LineMeal|null findOneBy(array $criteria, array $orderBy = null)
 * @method LineMeal[]    findAll()
 * @method LineMeal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineMealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LineMeal::class);
    }

    // /**
    //  * @return LineMeal[] Returns an array of LineMeal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LineMeal
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findLineMealByMeal($id)
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.meal', 'm')
            ->andWhere('m.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();

    }
}
