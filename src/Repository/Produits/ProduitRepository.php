<?php

namespace App\Repository\Produits;

use App\Entity\Produits\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function getAllPublicWithSousCategories($sous_categories)
    {
        return $this->createQueryBuilder('P')
            ->where('P.publier = 1')
            ->andWhere('P.sousCategorie = :sous_categories')
            ->setParameter('sous_categories', $sous_categories)
            ->orderBy('P.position', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getLastWithSousCategories($sous_categories)
    {
        return $this->createQueryBuilder('P')
            ->where('P.publier = 1')
            ->andWhere('P.sousCategorie = :sous_categories')
            ->setParameter('sous_categories', $sous_categories)
            ->orderBy('P.position', 'ASC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function getAllPublicWithProduit($produit_selected)
    {
        return $this->createQueryBuilder('P')
                   ->leftJoin('P.produits', 'R')
                   ->where('R = :produit_selected')
                   ->setParameter('produit_selected', $produit_selected)
                   ->andWhere('P.publier = 1')
                   ->orderBy('P.position', 'ASC')
                   ->getQuery()
                   ->getResult();
    }

    public function getAllPublicWithCategorie($categorie_selected)
    {
        return $this->createQueryBuilder('P')
            ->where('P.publier = 1')
            ->andWhere('P.categorie = :categorie_selected')
            ->setParameter('categorie_selected', $categorie_selected)
            ->orderBy('P.position', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
