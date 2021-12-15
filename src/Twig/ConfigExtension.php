<?php
namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Config;

class ConfigExtension extends AbstractExtension
{
 
	private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('valeurkey', [$this, 'getVeleurkey']),
        ];
    }

    public function getVeleurkey($key)
    {   if($key!=""){
        	$resulta =  $this->em->getRepository(Config::class)->findOneByName($key); 
        	if($resulta){
        		return $resulta->getValeur();
        	}
        	return "";
    	}
    	return ""; 
    }
}