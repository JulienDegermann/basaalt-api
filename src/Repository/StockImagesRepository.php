<?php

namespace App\Repository;

use App\Entity\ArticleImages;
use App\Entity\StockImages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArticleImages>
 *
 * @method ArticleImages|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleImages|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleImages[]    findAll()
 * @method ArticleImages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockImagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockImages::class);
    }

    //    /**
    //     * @return ArticleImages[] Returns an array of ArticleImages objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ArticleImages
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
