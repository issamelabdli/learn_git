<?php

namespace App\Controller\Backend;

use App\Entity\Page;
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
    AssociationField,
    NumberField
};
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;


use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Form\Field\CKEditorField;
use App\Form\Field\ImagevichField;



 
class PageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Page::class;
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
                    //ImagevichField::new('image')->setCustomOption('entity', getEntity()),
                   
                    ImageField::new('image')
                        ->setBasePath(
                            $this->getParameter('app.path.page_image')
                        ),
                    AssociationField::new('categorie'),
                    TextField::new('titre'), 
                    BooleanField::new('publier'),
                ];

            default:
                break;
        }
 
        return [
            FormField::addPanel('Information Page'),
            AssociationField::new('categorie'),
            TextField::new('titre'),
            TextField::new('slug'),
            BooleanField::new('publier'),
            NumberField::new('position'),
            
            TextareaField::new('imageFile')->setFormType(VichImageType::class),
            FormField::addPanel('Contenu Page'),
            TextareaField::new('preview'),
            CKEditorField::new('contenu', 'Contenu'),
            //TextareaField::new('contenu')->setFormType(CKEditorType::class),
            FormField::addPanel('Seo'),
            TextField::new('seo_titre'),
            TextareaField::new('seo_keywords'),
            TextareaField::new('seo_description'),  
        ];
    }
}
