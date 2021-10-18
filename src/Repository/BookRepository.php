<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */
    
    public function getPaginatedBooks($pageBook, $limit)
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.title', 'ASC')
            ->setFirstResult(($pageBook * $limit) - $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getPaginatedBooksByAutor($pageBook, $limit, $autorSlug)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.autorSlug = :val')
            ->setParameter('val', $autorSlug)
            ->orderBy('b.title', 'ASC')
            ->setFirstResult(($pageBook * $limit) - $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getPaginatedBooksByCategory($pageBook, $limit, $category)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.category = :val')
            ->setParameter('val', $category)
            ->orderBy('b.title', 'ASC')
            ->setFirstResult(($pageBook * $limit) - $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }
    
    
    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
