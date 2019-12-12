<?php

namespace App\Repository;

use App\Entity\LineRequestSupplied;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LineRequestSupplied|null find($id, $lockMode = null, $lockVersion = null)
 * @method LineRequestSupplied|null findOneBy(array $criteria, array $orderBy = null)
 * @method LineRequestSupplied[]    findAll()
 * @method LineRequestSupplied[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineRequestSuppliedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LineRequestSupplied::class);
    }

    // /**
    //  * @return LineRequestSupplied[] Returns an array of LineRequestSupplied objects
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
    public function findOneBySomeField($value): ?LineRequestSupplied
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findLineRequestSuppliedByRequestSupplied($id)
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.requestSupplied', 'r')
            ->andWhere('r.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();

    }
}
