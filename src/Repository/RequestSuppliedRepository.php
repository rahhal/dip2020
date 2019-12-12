<?php

namespace App\Repository;

use App\Entity\RequestSupplied;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RequestSupplied|null find($id, $lockMode = null, $lockVersion = null)
 * @method RequestSupplied|null findOneBy(array $criteria, array $orderBy = null)
 * @method RequestSupplied[]    findAll()
 * @method RequestSupplied[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequestSuppliedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RequestSupplied::class);
    }

    // /**
    //  * @return RequestSupplied[] Returns an array of RequestSupplied objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RequestSupplied
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function myFindOne($id)
    {
        return $this->createQueryBuilder('r')
                    ->where('r.id = :id')
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getResult()
                    ;
    }
}
