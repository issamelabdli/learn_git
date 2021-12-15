<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse; 
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\Routing\Annotation\Route; 
use Doctrine\ORM\EntityManagerInterface;
 
use App\Entity\{
    Page,
    Switcher,
    Actualite,
    Contact,
    Mediatheque
};
use App\Entity\Produits\{
    Categorie,
    SousCategorie,
    Produit
};
use App\Entity\Evenements\{
    Evenement,
    Client,
    Galerieclient
};

use App\Form\ContactpublicType;
use App\Form\ContactproduitType;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;



class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        $em                = $this->getDoctrine()->getManager();
        $page_selected     = $em->getRepository(Page::class)->findOneBySlug('homepage');
        $list_categories   = $em->getRepository(Categorie::class)->getAllPublic();
        $list_evenements   = $em->getRepository(Evenement::class)->getAllPublic();
        $list_actualites   = $em->getRepository(Actualite::class)->getListhome();
        $list_mediatheques = $em->getRepository(Mediatheque::class)->getListhome();
        
        return $this->render('Frontend/Page/index.html.twig', [
            'page_selected'     => $page_selected,
            'list_categories'   => $list_categories,
            'list_evenements'   => $list_evenements,
            'list_actualites'   => $list_actualites,
            'list_mediatheques' => $list_mediatheques
        ]);
    }
 
    /**
     * @Route("/_header", name="_header")
     */
    public function _header(): Response
    {
        $em             = $this->getDoctrine()->getManager(); 
        return $this->render('Frontend/_header.html.twig');
    }
    
    /**
     * @Route("/_footer", name="_footer")
     */
    public function _footer(): Response
    {
        return $this->render('Frontend/_footer.html.twig');
    }

 
    /**
     * @Route("/page/{slug}", name="page_single")
     */
    public function pagesingle($slug): Response
    {
        $em             = $this->getDoctrine()->getManager();
        $page_selected     = $em->getRepository(Page::class)->findOneBySlug($slug);
        return $this->render('Frontend/Page/layout-1-column.html.twig', [
            'page_selected'     => $page_selected
        ]);
    }

    /**
     * @Route("/catalogue", name="catalogue")
     */
    public function catalogue(): Response
    {
        $em                = $this->getDoctrine()->getManager();
        $page_selected     = $em->getRepository(Page::class)->findOneBySlug('catalogue');
        $list_categories   = $em->getRepository(Categorie::class)->getAllPublic();
        
        return $this->render('Frontend/Produits/catalogue.html.twig', [
            'page_selected'     => $page_selected,
            'list_categories'   => $list_categories
        ]);
    }

    /**
     * @Route("/catalogue/{slug}", name="categorie_selected")
     */
    public function categorie_selected($slug): Response
    {
        $em                   = $this->getDoctrine()->getManager();
        $categorie_selected   = $em->getRepository(Categorie::class)->findOneBy(['slug' => $slug, 'publier' => 1]);
        $list_sous_categories = $em->getRepository(SousCategorie::class)->getAllPublicWithCategorie($categorie_selected);
        $list_produits        = $em->getRepository(Produit::class)->getAllPublicWithCategorie($categorie_selected);

        if ($categorie_selected) {
            return $this->render('Frontend/Produits/categorie_selected.html.twig', [
                'categorie_selected'    => $categorie_selected,
                'list_sous_categories'  => $list_sous_categories,
                'list_produits'         => $list_produits
            ]);
        }
        exit();
        
    }

    /**
     * @Route("/catalogue/{cat_slug}/{slug}", name="sous_categorie_selected")
     */
    public function sous_categorie_selected($cat_slug, $slug): Response
    {
        $em                       = $this->getDoctrine()->getManager();
        $categorie_selected       = $em->getRepository(Categorie::class)->findOneBySlug($cat_slug);
        $sous_categorie_selected  = $em->getRepository(SousCategorie::class)->findOneBy(['slug' => $slug, 'publier' => 1]);
        $list_produits            = $em->getRepository(Produit::class)->getAllPublicWithSousCategories($sous_categorie_selected);
        
        if ($sous_categorie_selected) {
            return $this->render('Frontend/Produits/sous_categorie_selected.html.twig', [
                'categorie_selected'        => $categorie_selected,
                'sous_categorie_selected'   => $sous_categorie_selected,
                'list_produits'             => $list_produits
            ]);
        }
        exit();
    }

    /**
     * @Route("/catalogue/{cat_slug}/produit/{slug_produit}", name="produit_selected_cat")
     */
    public function produit_selected_cat($cat_slug, $slug_produit): Response
    {
        $em                       = $this->getDoctrine()->getManager();
        $produit_selected         = $em->getRepository(Produit::class)->findOneBy(['slug' => $slug_produit, 'publier' => 1]);
        if($produit_selected){
            $list_produits        = $em->getRepository(Produit::class)->getAllPublicWithProduit($produit_selected);
            return $this->render('Frontend/Produits/produit_selected_cat.html.twig', [
                'produit_selected'   => $produit_selected,
                'list_produits'      => $list_produits
            ]);
        }
        exit();
    }

    /**
     * @Route("/catalogue/{cat_slug}/{souscat_slug}/{slug}", name="produit_selected")
     */
    public function produit_selected($cat_slug, $souscat_slug, $slug): Response
    {
        $em                       = $this->getDoctrine()->getManager();
        $produit_selected         = $em->getRepository(Produit::class)->findOneBy(['slug' => $slug, 'publier' => 1]);
        if($produit_selected){
            $list_produits        = $em->getRepository(Produit::class)->getAllPublicWithProduit($produit_selected);
            return $this->render('Frontend/Produits/produit_selected.html.twig', [
                'produit_selected'   => $produit_selected,
                'list_produits'      => $list_produits
            ]);
        }
        exit();
    }

    /**
     * @Route("/contact-produit/{slug}", name="contact_produit")
     */   
    public function contact_produit(Request $request,$slug,MailerInterface $mailer): Response
    {
        $em               = $this->getDoctrine()->getManager();
        $contact          = new Contact();
        $produit_selected = $em->getRepository(Produit::class)->findOneBySlug($slug);

        $contact->setProduit($produit_selected);

        $form = $this->createForm(ContactproduitType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                /*$datamail = $this->sendEmail($form->getData(), 'Contact produit', "Frontend/Produits/_produit_template.html.twig");
                $mailer->send($datamail);*/
                $em->persist($contact);
                $em->flush();
                return new JsonResponse(array('type' => 'success', 'text' => 'Votre message a bien été envoyé'));
            }else{
                return new JsonResponse(array('type' => 'error', 'text' => 'serveur introuvable')); 
            }
        }

        return $this->render('Frontend/Produits/_contact_produit.html.twig', [
            'produit_selected' => $produit_selected,
            'form'             => $form->createView()
        ]);

    }

    protected function getErrorMessages(\Symfony\Component\Form\Form $form)
    {
        $errors = array();

        foreach ($form->getErrors() as $key => $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }

        return $errors;
    }

        
    /**
     * @Route("/evenements", name="evenements")
     */
    public function evenements(): Response
    {
        $em              = $this->getDoctrine()->getManager();
        $page_selected   = $em->getRepository(Page::class)->findOneBySlug('evenements');
        $list_evenements = $em->getRepository(Evenement::class)->getAllPublic();
        
        return $this->render('Frontend/Evenements/evenements.html.twig', [
            'page_selected'   => $page_selected,
            'list_evenements' => $list_evenements
        ]);
    }

    /**
     * @Route("/evenements/{slug}", name="evenement_selected")
     */
    public function evenement_selected($slug): Response
    {
        $em                   = $this->getDoctrine()->getManager();
        $evenement_selected   = $em->getRepository(Evenement::class)->findOneBy(['slug' => $slug, 'publier' => 1]);

        if ($evenement_selected) {
            
            $list_clients         = $em->getRepository(Client::class)->getAllPublicWithEvenement($evenement_selected);

            return $this->render('Frontend/Evenements/evenement_selected.html.twig', [
                'evenement_selected'  => $evenement_selected,
                'list_clients'        => $list_clients
            ]);
        }
        exit();
        
    }

    /**
     * @Route("/evenements/{event_slug}/{slug}", name="client_selected")
     */
    public function client_selected($event_slug, $slug): Response
    {
        $em                 = $this->getDoctrine()->getManager();
        $evenement_selected = $em->getRepository(Evenement::class)->findOneBy(['slug' => $event_slug, 'publier' => 1]);
        $client_selected    = $em->getRepository(Client::class)->findOneBy(['slug' => $slug, 'publier' => 1]);

        if ($client_selected) {
            
            $list_medias    = $em->getRepository(Galerieclient::class)->getAllPublicWithClient($client_selected);

            return $this->render('Frontend/Evenements/client_selected.html.twig', [
                'evenement_selected'  => $evenement_selected,
                'client_selected'     => $client_selected,
                'list_medias'         => $list_medias
            ]);
        }
        exit();
        
    }

    /**
     * @Route("/actualites", name="actualites")
     */
    public function actualites(Request $request): Response
    {
        $em                = $this->getDoctrine()->getManager();
        $page_selected     = $em->getRepository(Page::class)->findOneBySlug('actualites');
        $nbArticlesParPage = 7;
        $page_current      = $request->query->getInt('page', 1);
        $list_actualites   = $em->getRepository(Actualite::class)->findAllPagineEtTrie($page_current, $nbArticlesParPage);

        $pagination        = array(
            'page'        => $page_current,
            'nbPages'     => ceil(count($list_actualites) / $nbArticlesParPage),
            'nomRoute'    => 'actualites',
            'paramsRoute' => array()
        );
        
        return $this->render('Frontend/Actualites/actualites.html.twig', [
            'page_selected'   => $page_selected,
            'list_actualites' => $list_actualites,
            'pagination'      => $pagination
        ]);
    }

    /**
     * @Route("/actualites/{slug}", name="actualite_selected")
     */
    public function actualite_selected($slug): Response
    {
        $em                  = $this->getDoctrine()->getManager();
        $page_selected       = $em->getRepository(Page::class)->findOneBySlug('actualites');
        $actualite_selected  = $em->getRepository(Actualite::class)->findOneBy(['slug' => $slug, 'publier' => 1]);

        if ($actualite_selected) {

            return $this->render('Frontend/Actualites/actualite_selected.html.twig', [
                'page_selected'       => $page_selected,
                'actualite_selected'  => $actualite_selected
            ]);
        }
        exit();
        
    }

    /**
     * @Route("/mediatheque", name="mediatheque")
     */
    public function mediatheque(Request $request): Response
    {
        $em                   = $this->getDoctrine()->getManager();
        $page_selected        = $em->getRepository(Page::class)->findOneBySlug('mediatheque');
        $event_selected       = $request->query->get('evenement');
        $souscat_selected     = $request->query->get('sous-categorie');

        $nbArticlesParPage    = 12;
        $page_current         = $request->query->getInt('page', 1);
        $list_mediatheques    = $em->getRepository(Mediatheque::class)->findAllPagineEtTrie($page_current, $nbArticlesParPage, $event_selected, $souscat_selected);

        $list_sous_categories = $em->getRepository(SousCategorie::class)->getAllPublic();
        $list_evenements      = $em->getRepository(Evenement::class)->getAllPublic();

        $pagination           = array(
            'page'        => $page_current,
            'nbPages'     => ceil(count($list_mediatheques) / $nbArticlesParPage),
            'nomRoute'    => 'mediatheque',
            'paramsRoute' => array('evenement' => $event_selected, 'sous-categorie' => $souscat_selected)
        );
        
        return $this->render('Frontend/Mediatheque/mediatheque.html.twig', [
            'page_selected'        => $page_selected,
            'list_mediatheques'    => $list_mediatheques,
            'list_sous_categories' => $list_sous_categories,
            'list_evenements'      => $list_evenements,
            'event_selected'       => $event_selected,
            'souscat_selected'     => $souscat_selected,
            'pagination'           => $pagination
        ]);
    }


    /**
     * @Route("/contact", name="contact_link")
     */
    public function contact(Request $request,MailerInterface $mailer): Response
    {

        $contact        = new Contact();
        $em             = $this->getDoctrine()->getManager();
        $page_selected  = $em->getRepository(Page::class)->findOneBySlug('contact');

        $form           = $this->createForm(ContactpublicType::class,$contact,array( 
                                                'action' => $this->generateUrl('contact_link'),
                                                'method' => 'POST'
                                            ));   

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isValid()){

                /*$datamail = $this->sendEmail($form->getData(), 'Contact Boitaloc', "Frontend/Contact/_contact_template.html.twig");
                $mailer->send($datamail);*/
                $em->persist($contact);
                $em->flush();  

                $request->getSession()->getFlashBag()->add('notice', 'Votre message a bien été envoyé');
                return $this->redirectToRoute('contact_link');
            
            }else{
                $request->getSession()->getFlashBag()->add('notice_error', 'Votre form invalide');
            }
        }

        return $this->render('Frontend/Contact/contact.html.twig',array( 
                                'page_selected' => $page_selected,
                                'form'          => $form->createView()
                            ));
    }


    private function sendEmail($data,$object,$template)
    {

        $dataview  =  $this->renderView($template,array('contact'=>$data)); 
        
        $email = (new Email())
        ->from($this->getParameter('mail_envoie') )
        ->to($this->getParameter('mail_reception') )
        ->subject($object) 
        ->html($dataview);

        return $email;
 
    }

   
}
