<?php

namespace App\Repository;

use App\Entity\Currency;
use App\Schema\DataFilter\CurrencySchema;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Currency|null find($id, $lockMode = null, $lockVersion = null)
 * @method Currency|null findOneBy(array $criteria, array $orderBy = null)
 * @method Currency[]    findAll()
 * @method Currency[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Currency::class);
    }

    public function findBySchema(CurrencySchema $searchQuerySchema)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.name LIKE :name')
            ->setParameter('name', '%' . $searchQuerySchema->getSearch() . '%')
            ->setFirstResult($searchQuerySchema->getPerPage() * ($searchQuerySchema->getPage() - 1))
            ->setMaxResults($searchQuerySchema->getPerPage())
            ->orderBy('q.' . $searchQuerySchema->getOrderByField(), $searchQuerySchema->getOrderByDirection())
            ->getQuery()
            ->getResult();
    }

    public function findCountBySchema(CurrencySchema $searchQuerySchema)
    {
        return $this->createQueryBuilder('q')
            ->select('count(q.id)')
            ->andWhere('q.name LIKE :name')
            ->setParameter('name', '%' . $searchQuerySchema->getSearch() . '%')
            ->getQuery()
            ->getSingleScalarResult();
    }

    // /**
    //  * @return Currency[] Returns an array of Currency objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Currency
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
