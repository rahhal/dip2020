<?php

namespace App\Repository;

use App\Entity\Journal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Journal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Journal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Journal[]    findAll()
 * @method Journal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JournalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Journal::class);
    }

    // /**
    //  * @return Journal[] Returns an array of Journal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Journal
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findJournalByNbMeal($id)
    {
        return $this->createQueryBuilder('j')
            ->innerJoin('j.nbMeal', 'n')
            ->andWhere('n.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();
    }
    public function findJournalByCurrentDate()
    {
        return $this
            ->createQueryBuilder('j')
            ->andWhere('j.date = :date')
            ->setParameter('date', new \Datetime(date('d-m-Y')))
            ->getQuery()
            //->getOneOrNullResult()
            ->getResult();
    }
}
