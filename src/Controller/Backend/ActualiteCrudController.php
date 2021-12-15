<?php

namespace App\Controller\Backend;

use App\Entity\Actualite;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;

use EasyCorp\Bundle\EasyAdminBundle\Field\{ 
    TextField,
    BooleanField, 
    TextareaField,
    ImageField,
    FormField,  
    NumberField,
    DateTimeField
};
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType; 

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Form\Field\CKEditorField;
use App\Form\Field\ImagevichField;



class ActualiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Actualite::class;
    }



    public function configureAssets(Assets $assets): Assets
    {
        return Assets::new()->addCssFile('assets/lib/admin/admineyse.css');
        //return $assets;
    }
 

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }
     
    public function configureFields(string $pageName): iterable
    {
        switch ($pageName) {
            case Crud::PAGE_INDEX:
                return [  
                    ImageField::new('image')
                        ->setBasePath(
                            $this->getParameter('app.path.actualite_image')
                        ),
                    TextField::new('titre'),
                    DateTimeField::new('date_publication','Publie le'),
                    DateTimeField::new('created_at','cree le'), 
                    BooleanField::new('publier'),
                ];

            default:
                break;
        }
     

        return [
            FormField::addPanel('Information Page'), 
            TextField::new('titre'),
            DateTimeField::new('date_publication', 'Publie le'),
            BooleanField::new('publier'),  
            TextareaField::new('imageFile')->setFormType(VichImageType::class),
            FormField::addPanel('Contenu Page'),
            TextareaField::new('preview'),
            CKEditorField::new('contenu', 'Contenu'), 
            FormField::addPanel('Seo'),
            TextField::new('seo_titre'),
            TextareaField::new('seo_meta'),
            TextareaField::new('seo_description'),  
        ];
    }
 
}
