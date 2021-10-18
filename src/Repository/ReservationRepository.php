<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    // /**
    //  * @return Reservation[] Returns an array of Reservation objects
    //  */
    
    public function findReservations($user)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.user = :val')
            ->andWhere('r.validate = :v')
            ->setParameter('val', $user)
            ->setParameter('v', false)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findLocations($user)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.user = :val')
            ->andWhere('r.validate = :v')
            ->setParameter('val', $user)
            ->setParameter('v', true)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    /**
     * Get all nonValidate reservations
     */
    public function getNonValidateReservations()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.validate = :val')
            ->setParameter('val', false)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Reservation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
