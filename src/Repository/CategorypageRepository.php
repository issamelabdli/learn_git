<?php

namespace App\Repository;

use App\Entity\Categorypage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categorypage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorypage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorypage[]    findAll()
 * @method Categorypage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorypageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorypage::class);
    }

    // /**
    //  * @return Categorypage[] Returns an array of Categorypage objects
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
    public function findOneBySomeField($value): ?Categorypage
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
