<?php

namespace App\Repository;

use App\Entity\Stock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stock>
 *
 * @method BandMember|null find($id, $lockMode = null, $lockVersion = null)
 * @method BandMember|null findOneBy(array $criteria, array $orderBy = null)
 * @method BandMember[]    findAll()
 * @method BandMember[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BandMemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stock::class);
    }
}
