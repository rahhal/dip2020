<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
   /* public function stockIni()
    {
        $query = $this
            ->createQueryBuilder('a')
            ->select( a.{id})
            ->getQuery();

       var_dump($query->getSQL());
        die();

        return $query->getResult();
    }*/
    public function findArticleByCategory($id)
    {
        /*$entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p, c
        FROM App\Entity\Article a
        INNER JOIN a.category c
        WHERE a.id = :id')
            ->setParameter('id', $articleId);

        return $query->getOneOrNullResult();*/

        return $this->createQueryBuilder('a')
            ->innerJoin('a.Category', 'c')
            ->andWhere('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            // ->getOneOrNullResult();
            ->getResult();
    }
    public function search($searchParam) {
        extract($searchParam);
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.category','cat')
            ->addSelect('cat');
        return $qb->getQuery();
    }
}
