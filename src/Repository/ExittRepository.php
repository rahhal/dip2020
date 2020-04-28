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
    public function findExittByJournal($id)
    {
        return $this->createQueryBuilder('e')
            ->innerJoin('e.journals', 'j')
            ->andWhere('j.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();
    }

    public function findByCurrentDate($user)
    {
        return $this
            ->createQueryBuilder('e')
            ->where('e.date = :date')
            ->andWhere('e.user = :user')
            ->setParameter('date', new \Datetime(date('d-m-Y')))
            ->setParameter('user', $user)
            ;
    }

    public function myFindByCurrentDate($user)
    {
        return $this
            ->createQueryBuilder('e')
            ->where('e.date = :date')
            ->andWhere('e.user = :user')
            ->setParameter('date', new \Datetime(date('d-m-Y')))
            ->setParameter('user', $user)
            ->getQuery()
            //->getOneOrNullResult()
            ->getResult();
    }

    public function checkOneExitByDate($user)
    {
	    $current_date = new \DateTime();
	    $current_date_format = $current_date->format('Y-m-d');

	    $query = $this
		    ->createQueryBuilder('e')
		    ->Where('e.date = :date')
            ->andWhere('e.user = :user')
		    ->setParameter('date', $current_date_format)
            ->setParameter('user', $user)
            ->getQuery()
		    ->getResult();

	    if (!empty($query)) {
	    	return true;
	    }

	    return false;
    }
    public function findExittByUser($id)
    {
        return $this->createQueryBuilder('e')
            ->innerJoin('e.user', 'u')
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();
    }
}
