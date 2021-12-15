<?php

namespace App\Controller\Backend;

use App\Entity\Produits\Categorie;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Field\{
    Field,
    TextField,
    BooleanField,
    NumberField,
    TextareaField,
    ImageField,
    FormField,
    ChoiceField,
    AssociationField,
    CollectionField
};

use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class CategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categorie::class;
    }
    public function configureAssets(Assets $assets): Assets
    {
        return Assets::new()->addCssFile('assets/lib/admin/admineyse.css'); 
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
                            $this->getParameter('app.path.image_categorie')
                        ),
                    TextField::new('titre'),
                    NumberField::new('position'),
                    BooleanField::new('publier')
                ];

            default:
                break;
        }
        return [

            
            FormField::addPanel('Information Categorie'),
            TextField::new('titre'),

            FormField::addPanel('Config Categorie & media'),
            NumberField::new('position'),
            BooleanField::new('publier'),
            TextareaField::new('imageFile', 'Image')->setFormType(VichImageType::class),
            TextareaField::new('image2File', 'Image hover')->setFormType(VichImageType::class),

            FormField::addPanel('Information Seo'),
            TextField::new('seo_titre'),
            TextareaField::new('seo_description'),
            TextareaField::new('seo_keywords'),

        ];
    } 
 




}
