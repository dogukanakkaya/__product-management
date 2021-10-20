<?php

namespace App\Repository\Stock;

use App\Entity\Stock\StockTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StockTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockTranslation[]    findAll()
 * @method StockTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockTranslation::class);
    }

    // /**
    //  * @return StockTranslation[] Returns an array of StockTranslation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StockTranslation
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
