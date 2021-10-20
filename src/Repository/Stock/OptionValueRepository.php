<?php

namespace App\Repository\Stock;

use App\Entity\Stock\OptionValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OptionValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method OptionValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method OptionValue[]    findAll()
 * @method OptionValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OptionValue::class);
    }

    // /**
    //  * @return OptionValue[] Returns an array of OptionValue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OptionValue
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
