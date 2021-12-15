<?php

namespace App\Controller\Backend;

use App\Entity\Mediatheque;

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


class MediathequeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Mediatheque::class;
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
                            $this->getParameter('app.path.image_mediatheque')
                        ),
                    TextField::new('titre'),
                    AssociationField::new('sousCategorie', 'Sous-Categorie'),
                    AssociationField::new('evenement', 'Evenement'),
                    NumberField::new('position'),
                    BooleanField::new('publier')
                ];

            default:
                break;
        }
        return [

            FormField::addPanel('Information Sous-categorie'),
            TextField::new('titre'),
            AssociationField::new('sousCategorie', 'Sous-Categorie'),
            AssociationField::new('evenement', 'Evenement'),

            FormField::addPanel('Config & media'),
            NumberField::new('position'),
            BooleanField::new('publier'),
            TextareaField::new('imageFile', 'Image')->setFormType(VichImageType::class),
            TextField::new('video', 'Lien video'),

        ];
    } 
 




}
