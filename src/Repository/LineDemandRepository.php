<?php

namespace App\Repository;

use App\Entity\LineDemand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LineDemand|null find($id, $lockMode = null, $lockVersion = null)
 * @method LineDemand|null findOneBy(array $criteria, array $orderBy = null)
 * @method LineDemand[]    findAll()
 * @method LineDemand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineDemandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LineDemand::class);
    }

    // /**
    //  * @return LineDemand[] Returns an array of LineDemand objects
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
    public function findOneBySomeField($value): ?LineDemand
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findLineDemandByDemand($id)
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.demand', 'd')
            ->andWhere('d.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();

    }
}
