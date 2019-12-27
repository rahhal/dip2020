<?php

namespace App\Repository;

use App\Entity\NbMeal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method NbMeal|null find($id, $lockMode = null, $lockVersion = null)
 * @method NbMeal|null findOneBy(array $criteria, array $orderBy = null)
 * @method NbMeal[]    findAll()
 * @method NbMeal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NbMealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NbMeal::class);
    }

    // /**
    //  * @return NbMeal[] Returns an array of NbMeal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NbMeal
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function NbMealtByJournal($id)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.journals', 'j')
            ->andWhere('j.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
          //  ->getResult();

    }
    public function findNbMealByDate($date)
    { return $this->createQueryBuilder('n')
        ->andWhere('n.journals = :date')
        ->setParameter('date', new \Datetime(date('d-m-Y')))
        //->setParameter('datecourant', new \Datetime(date('d-m-Y')))
        ->getQuery()
        ->getOneOrNullResult()
        ;
    }
}
