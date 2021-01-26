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
    public function search(string $date, string $addressStart, string $addressEnd, ?object $currentUser): array
    {
        return $this->createQueryBuilder('t')
            ->where("t.addressStart  = :addressStart")
            ->andWhere("t.addressEnd = :addressEnd")
            ->andWhere("t.date LIKE :date")
            ->andWhere("t.date  >= CURRENT_DATE()")
            ->andWhere("t.nbPassengers  > 0")
            ->andWhere("t.Driver != :currentUser OR :currentUser IS NULL")
            ->setParameter('addressStart', $addressStart)
            ->setParameter('addressEnd', $addressEnd)
            ->setParameter('date', '%' . $date . '%')
            ->setParameter('currentUser', $currentUser)
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

    /**
     * @return Trip[]
     */
    public function countTrips(int $user)
    {
        return $this->createQueryBuilder('t')
            ->select('count(t.Driver) as all_trips')
            ->where("t.date  < CURRENT_DATE()")
            ->andWhere("t.Driver  = :user")
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @return Trip[]
     */
    public function newDriverTrip(int $currentUser): ?array
    {
        return $this->createQueryBuilder('t')
            ->where("t.date  > CURRENT_DATE()")
            ->andWhere("t.Driver  = :currentUser")
            ->orderBy("t.date")
            ->setParameter('currentUser', $currentUser)
            ->getQuery()
            ->getResult()
        ;
    }
}
