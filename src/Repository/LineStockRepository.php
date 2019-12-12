<?php

namespace App\Repository;

use App\Entity\lineStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method lineStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method lineStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method lineStock[]    findAll()
 * @method lineStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, lineStock::class);
    }

    // /**
    //  * @return lineStock[] Returns an array of lineStock objects
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
    public function findOneBySomeField($value): ?lineStock
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
