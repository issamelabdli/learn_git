<?php

namespace App\Repository;

use App\Entity\Mediatheque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Mediatheque|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mediatheque|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mediatheque[]    findAll()
 * @method Mediatheque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediathequeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mediatheque::class);
    }

    public function getListhome()
    {
        return $this->createQueryBuilder('M')
            ->where('M.publier = 1')
            ->orderBy('M.position', 'ASC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère une liste d'articles triés et paginés.
     *
     * @param int $page Le numéro de la page
     * @param int $nbMaxParPage Nombre maximum d'article par page     
     *
     * @throws InvalidArgumentException
     * @throws NotFoundHttpException
     *
     * @return Paginator
     */
    public function findAllPagineEtTrie($page, $nbMaxParPage, $event_selected, $souscat_selected)
    {
        if (!is_numeric($page)) {
            throw new InvalidArgumentException(
                'La valeur de l\'argument $page est incorrecte (valeur : ' . $page . ').'
            );
        }

        if ($page < 1) {
            throw new NotFoundHttpException('La page demandée n\'existe pas');
        }
        if (!is_numeric($nbMaxParPage)) {
            throw new InvalidArgumentException(
                'La valeur de l\'argument $nbMaxParPage est incorrecte (valeur : ' . $nbMaxParPage . ').'
            );
        }


        $qb =  $this->createQueryBuilder('M')
                    ->leftJoin('M.evenement', 'E')
                    ->leftJoin('M.sousCategorie', 'S')
                    ->where('M.evenement = E')
                    ->andWhere('M.sousCategorie = S')
                    ->andWhere('M.publier = 1')
                    ->orderBy('M.position', 'ASC');

        if($event_selected!=""){
            $qb->andWhere('E.slug = :event_selected')
               ->setParameter( 'event_selected' , $event_selected);
        }

        if($souscat_selected!=""){
            $qb->andWhere('S.slug = :souscat_selected')
               ->setParameter( 'souscat_selected' , $souscat_selected);
        }
                
        $query = $qb->getQuery();

        $premierResultat = ($page - 1) * $nbMaxParPage;
        $query->setFirstResult($premierResultat)->setMaxResults($nbMaxParPage);
        $paginator = new Paginator($query);

        if (($paginator->count() <= $premierResultat) && $page != 1) {
            throw new NotFoundHttpException('La page demandée n\'existe pas.'); // page 404, sauf pour la première page
        }

        return $paginator;
    }

    // /**
    //  * @return Mediatheque[] Returns an array of Mediatheque objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mediatheque
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
