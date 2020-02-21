<?php

namespace App\Repository;

use App\Entity\LineInventory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LineInventory|null find($id, $lockMode = null, $lockVersion = null)
 * @method LineInventory|null findOneBy(array $criteria, array $orderBy = null)
 * @method LineInventory[]    findAll()
 * @method LineInventory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineInventoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LineInventory::class);
    }

    // /**
    //  * @return LineInventory[] Returns an array of LineInventory objects
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
    public function findOneBySomeField($value): ?LineInventory
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findLineInventoryByInventory($id)
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.inventory', 'i')
            ->andWhere('i.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();
    }
}
