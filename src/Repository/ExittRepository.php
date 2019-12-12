<?php

namespace App\Repository;

use App\Entity\Exitt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Exitt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exitt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exitt[]    findAll()
 * @method Exitt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExittRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exitt::class);
    }

    // /**
    //  * @return Exitt[] Returns an array of Exitt objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Exitt
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */



}
