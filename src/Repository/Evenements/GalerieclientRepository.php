<?php

namespace App\Repository\Evenements;

use App\Entity\Evenements\Galerieclient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Galerieclient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Galerieclient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Galerieclient[]    findAll()
 * @method Galerieclient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalerieclientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Galerieclient::class);
    }

    public function getAllPublicWithClient($client)
    {
        return $this->createQueryBuilder('C')
                    ->where('C.client = :client')
                    ->setParameter('client', $client)
                    ->orderBy('C.position', 'ASC')
                    ->getQuery()
                    ->getResult();
    }

    // /**
    //  * @return Galerieclient[] Returns an array of Galerieclient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Galerieclient
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
