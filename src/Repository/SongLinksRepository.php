<?php

namespace App\Repository;

use App\Entity\SongLinks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SongLinks>
 *
 * @method SongLinks|null find($id, $lockMode = null, $lockVersion = null)
 * @method SongLinks|null findOneBy(array $criteria, array $orderBy = null)
 * @method SongLinks[]    findAll()
 * @method SongLinks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SongLinksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SongLinks::class);
    }

    //    /**
    //     * @return SongLinks[] Returns an array of SongLinks objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SongLinks
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
