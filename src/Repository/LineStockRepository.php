<?php

namespace App\Repository;

use App\Entity\LineStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LineStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method LineStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method LineStock[]    findAll()
 * @method LineStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LineStock::class);
    }

    // /**
    //  * @return LineStock[] Returns an array of LineStock objects
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
    public function findOneBySomeField($value): ?LineStock
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findLineStockByLineInventory($id)
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.lineInventories', 'li')
            ->andWhere('li.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();
    }
    public function findLineStockByLineExitt($id)
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.lineExitts', 'li')
            ->andWhere('li.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();
    }

    public function findByArticle($article)
{
    return $this
        ->createQueryBuilder('l')
        ->andWhere('l.article = :article')
        ->setParameter('article',$article )
        ;
}
   /* public function findByArticle($id)
    {
        return $this
            ->createQueryBuilder('l')
            ->innerJoin('l.lineInventories', 'li')
            ->andWhere('l.id = :i')
            ->setParameter('id',$id )
            ;
    }*/
  /*  public function findLineStockByStock($id)
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.stock', 's')
            ->andWhere('s.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();
    }*/
    public function findLineStockByUser($id)
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.user', 'u')
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();
    }
}
