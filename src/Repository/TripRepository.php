<?php

namespace App\Repository;

use App\Entity\Trip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trip|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trip|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trip[]    findAll()
 * @method Trip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TripRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trip::class);
    }

    // /**
    //  * @return Trip[] Returns an array of Trip objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trip
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Trip[]
     */
    public function search(string $date, string $addressStart, string $addressEnd): array
    {
        return $this->createQueryBuilder('t')
            ->where("t.addressStart  = :addressStart")
            ->andWhere("t.addressEnd = :addressEnd")
            ->andWhere("t.date = :date")
            ->andWhere("t.date  >= CURRENT_DATE()")
            ->setParameter('addressStart', $addressStart)
            ->setParameter('addressEnd', $addressEnd)
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Trip[]
     */
    public function history()
    {
        return $this->createQueryBuilder('t')
            ->where("t.date  < CURRENT_DATE()")
            ->getQuery()
            ->getResult()
        ;
    }
}
