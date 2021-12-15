<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Produits\SousCategorie;

class SousCategorieExtension extends AbstractExtension
{

    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('Sous_categorie_list', [$this, 'getListe']),
        ];
    }

    public function getListe($slug)
    { 
        $resulta =  $this->em->getRepository(SousCategorie::class)->getAllPublicWithCategorieMax($slug);
        if ($resulta) {
            return $resulta;
        }
        return "";
    }
}
