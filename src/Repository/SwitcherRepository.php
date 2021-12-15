<?php

namespace App\Repository;

use App\Entity\Switcher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Switcher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Switcher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Switcher[]    findAll()
 * @method Switcher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SwitcherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Switcher::class);
    }


    public function getListpublic()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.publier = :val')
            ->setParameter('val', 1)
            ->orderBy('s.position', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
    
    // /**
    //  * @return Switcher[] Returns an array of Switcher objects
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
    public function findOneBySomeField($value): ?Switcher
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
