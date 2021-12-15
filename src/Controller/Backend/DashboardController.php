<?php

namespace App\Controller\Backend;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\{
    User,  
    Switcher,
    Page,
    Block,
    Config,
    Categorypage, 
    Actualite,
    Contact,
    Mediatheque
};
use App\Entity\Produits\{
    Categorie,
    SousCategorie,
    Produit,
    Specification,
    Galerie
};
use App\Entity\Evenements\{
    Evenement,
    Client,
    Galerieclient
};


/**
 * @Route("/sitewebadmin")
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/", name="admin_home")
     */
    public function index(): Response
    {
        return $this->render('Backend/dashboard.html.twig');
         
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Boitaloc');
    }
 
    
    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),   
            MenuItem::subMenu('Config géneral', 'fa fa-cogs')->setSubItems([
                MenuItem::linkToCrud('Config', 'fa fa-tags', Config::class),
                MenuItem::linkToCrud('Utilisateur', 'fa fa-tags', User::class),
            ]),
 
            MenuItem::subMenu('Gestion Contenu', 'fa fa-tasks')->setSubItems([ 
                MenuItem::linkToCrud('Catégorie', 'fa fa-tags', Categorypage::class),
                MenuItem::linkToCrud('Page', 'fa fa-tags', Page::class),
                MenuItem::linkToCrud('Block', 'fa fa-tags', Block::class),
                MenuItem::linkToCrud('Switcher', 'fa fa-tags', Switcher::class),
            ]),

            MenuItem::subMenu('Gestion Produits', 'fa fa-tasks')->setSubItems([
                MenuItem::linkToCrud('Categorie', 'fa fa-tags', Categorie::class),
                MenuItem::linkToCrud('SousCategorie', 'fa fa-tags', SousCategorie::class),
                MenuItem::linkToCrud('Produit', 'fa fa-tags', Produit::class)
            ]),

            MenuItem::subMenu('Gestion Evenements', 'fa fa-tasks')->setSubItems([
                MenuItem::linkToCrud('Evenement', 'fa fa-tags', Evenement::class),
                MenuItem::linkToCrud('Client', 'fa fa-tags', Client::class)
            ]),

            MenuItem::subMenu('Contact', 'fa fa-tasks')->setSubItems([
                MenuItem::linkToCrud('Contact', 'fa fa-tags', Contact::class),
            ]),

            MenuItem::subMenu('Gestion Actualites', 'fa fa-tasks')->setSubItems([
                MenuItem::linkToCrud('Actualite', 'fa fa-tags', Actualite::class)
            ]),

            MenuItem::subMenu('Gestion Médiathèque', 'fa fa-tasks')->setSubItems([
                MenuItem::linkToCrud('Médiathèque', 'fa fa-tags', Mediatheque::class)
            ]),


        ];
 



    }
    
}
