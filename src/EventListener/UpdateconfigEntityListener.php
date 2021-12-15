<?php

namespace App\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;

use Symfony\Component\HttpFoundation\Session\Session;  
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Yaml;

 

use App\Entity\Config;
 
 
 
class UpdateconfigEntityListener
{


    private $session; 

    public function __construct(Session $session)
    {
        $this->session = $session; 
    }



    public function prePersist(LifecycleEventArgs $args)
    {
 
        $entity = $args->getEntity(); 
       

        $path_config= __DIR__."/../../config/packages/parametreconfig.yml";
        

        if ($entity instanceof Config) {
            
            $em     = $args->getEntityManager();  

            $list_config = $em->getRepository(Config::class)->findAll();
            
            $tableadd = []; 
            $tablecontenuconfig = [];
            $twig = [];
            $globals = [];
            foreach ($list_config as $configobject) {
                $tablecontenuconfig[$configobject->getName()] = $configobject->getValeur();
            }



            $tablecontenuconfig[$entity->getName()] = $entity->getValeur();

            $tableadd['parameters'] = $tablecontenuconfig;
            $tableadd['twig']['globals'] =  $tablecontenuconfig;  
 
            file_put_contents($path_config, Yaml::dump($tableadd));

        }   
    } 
    public function preUpdate(LifecycleEventArgs $args)
    {
 
        $entity = $args->getEntity(); 
       

        $path_config= __DIR__."/../../config/packages/parametreconfig.yml";
        

        if ($entity instanceof Config) {
            
            $em     = $args->getEntityManager();  

            $list_config = $em->getRepository(Config::class)->findAll();
            
            $tableadd = []; 
            $tablecontenuconfig = [];
            $twig = [];
            $globals = [];
            foreach ($list_config as $configobject) {
                $tablecontenuconfig[$configobject->getName()] = $configobject->getValeur();
            }



            $tablecontenuconfig[$entity->getName()] = $entity->getValeur();

            $tableadd['parameters'] = $tablecontenuconfig;
            $tableadd['twig']['globals'] =  $tablecontenuconfig;  
 
            file_put_contents($path_config, Yaml::dump($tableadd));

        }   
    }


}

