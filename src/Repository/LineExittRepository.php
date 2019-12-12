<?php

namespace App\Repository;

use App\Entity\LineExitt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LineExitt|null find($id, $lockMode = null, $lockVersion = null)
 * @method LineExitt|null findOneBy(array $criteria, array $orderBy = null)
 * @method LineExitt[]    findAll()
 * @method LineExitt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineExittRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LineExitt::class);
    }

    // /**
    //  * @return LineExitt[] Returns an array of LineExitt objects
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
    public function findOneBySomeField($value): ?LineExitt
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findLineExittByExitt($id)
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.exitt', 'e')
            ->andWhere('e.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();

    }
    public function findLineExittByJournal($id)
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.exitt', 'e')
            ->leftJoin('e.journals', 'j')
            ->andWhere('j.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();

    }
    public function findOneLineExittByQuantity($quantity): ?LineExitt
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.lineExitt = :val')
            ->setParameter('val', $quantity)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findLineExittByDate($id, \DateTime $date)
    {
        /*return $this->createQueryBuilder('l')
            ->leftJoin('l.journals', 'j')
            ->Where('j.id = :id')
            ->setParameter('id', $id)
            ->leftJoin('l.exitt', 'e')
            ->andWhere('e.date = j.date')
            ->setParameter('date', $date->format('Y-m-d'))
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();*/
        return $this->createQueryBuilder('l')
            ->leftJoin('l.journals', 'j')
            ->leftJoin('l.exitt', 'e')
            ->Where('j.id = :id' and 'e.date = :date')
            ->setParameter('id', $id)
            //->andWhere('e.date = j.date')
            ->setParameter('date', $date->format('Y-m-d'))
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();

    }
    /*public function getEntityFromDate(\DateTime $date, $max)
    {
        return $this->getEntityManager()
            ->createQueryBuilder();
        ->select('entities')
        ->from('MyAppNameBundle:Entity','entities')
        ->where('(entities.date) >= :date')
        ->orderBy('entities.date','DESC')
        ->setParameter('date', $date->format('Y-m-d'))
        ->setMaxResults($max)
        ->getResult();
    }*/
        /*SELECT line_exitt.article_id, line_exitt.quantity, line_exitt.unit_price, line_exitt.total_price
        FROM line_exitt
        LEFT JOIN journal
        ON line_exitt.id = journal.line_exitt_id
        LEFT JOIN exitt
        ON   exitt.id = line_exitt.exitt_id
        where exitt.date = CURRENT_DATE*/
}
