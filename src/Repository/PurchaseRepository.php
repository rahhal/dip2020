<?php

namespace App\Repository;

use App\Entity\Purchase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Purchase|null find($id, $lockMode = null, $lockVersion = null)
 * @method Purchase|null findOneBy(array $criteria, array $orderBy = null)
 * @method Purchase[]    findAll()
 * @method Purchase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Purchase::class);
    }

    // /**
    //  * @return Purchase[] Returns an array of Purchase objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Purchase
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function myFindOne($id)
    {
        return $this->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function getPurchaseFromDate($max = 5)
    {
        $currentdate = new \DateTime('now'); //Date du jour
        // $em = $this->container->get('doctrine')->getEntityManager();
        return $this->createQueryBuilder('p')
            // ->select('entities')
            //  ->from('MyAppNameBundle:Entity','entities')
            ->where('(p.date) >= :date')
            // ->orderBy('p.date','DESC')
            ->setParameter('date', $currentdate->format('Y-m-d'))
            ->setMaxResults($max)//Limiter le nombre de résultat
            ->getQuery()
            ->getResult();
    }
    public function getPurchaseByMonth($date)
        {
            return $this->createQueryBuilder('p')
                        ->select(' MONTH(p.date) AS gBmonth, DAY(p.date) AS gBday')
                        ->where('p.date IS NOT NULL')
                        ->groupBy('gBmonth')
                        ->addGroupBy('gBday')
                        ->getQuery()
                        ->getResult();
        }
}