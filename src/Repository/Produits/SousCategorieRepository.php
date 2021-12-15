<?php

namespace App\Repository\Produits;

use App\Entity\Produits\SousCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SousCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method SousCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method SousCategorie[]    findAll()
 * @method SousCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SousCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SousCategorie::class);
    }

    public function getAllPublic()
    {
        return $this->createQueryBuilder('S')
            ->where('S.publier = 1')
            ->orderBy('S.position', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getAllPublicWithCategorie($categorie_selected)
    {
        return $this->createQueryBuilder('S')
            ->where('S.publier = 1')
            ->andWhere('S.categorie = :categorie_selected')
            ->setParameter('categorie_selected', $categorie_selected)
            ->orderBy('S.position', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getAllPublicWithCategorieMax($slug)
    {
        return $this->createQueryBuilder('S')
            ->leftJoin('S.categorie',' C')
            ->where('S.categorie = C')
            ->andWhere('C.slug = :categorie_selected')
            ->andWhere('S.publier = 1')
            ->setParameter('categorie_selected', $slug)
            ->orderBy('S.position', 'ASC')
            ->setMaxResults(8)
            ->getQuery()
            ->getResult();
    }


    // /**
    //  * @return SousCategorie[] Returns an array of SousCategorie objects
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
    public function findOneBySomeField($value): ?SousCategorie
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
